<?php

namespace App\Http\Controllers;

use App\Interfaces\IPermissionRepository;
use App\Interfaces\IRoleRepository;
use App\Interfaces\IUserRepository;
use App\Services\Efetivo\GetEffectiveList;
use App\Support\DataList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use DataList;

    private IRoleRepository $roleRepository;
    private IPermissionRepository $permissionRepository;

    public function __construct(
        IUserRepository $userRepository,
        IRoleRepository $roleRepository,
        IPermissionRepository $permissionRepository
    )
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;

        $this->middleware('permission:user-list|user-create|user-edit|user-delete|user-active|user-desactive', ['only' => ['index','history','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:profile-show', ['only' => ['profile']]);
        $this->middleware('permission:profile-edit', ['only' => ['updateProfile']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-desactive', ['only' => ['desactivate','getDatatableDeleteList']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-restore', ['only' => ['restore']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'usuarios',
            'page_name' => 'listar_usuarios',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->userRepository->getFieldList());
        $config = $this->getConfig($this->userRepository->getFieldList(), 'user.activeList');
        //$motoristas = $this->motoristaRepository->listActive();

        return view('users.index',[
            'heads' => $heads,
            'config' => $config
        ])->with($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function history()
    {
        $data = [
            'category_name' => 'usuarios',
            'page_name' => 'historico_usuario',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->userRepository->getFieldList());
        $config = $this->getConfig($this->userRepository->getFieldList(), 'user.deletedList');

        return view('users.history',[
            'heads' => $heads,
            'config' => $config
        ])->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'category_name' => 'usuarios',
            'page_name' => 'cadastrar_usuario',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('users.create', [
            'users' => (new GetEffectiveList())->call() ?? [],
            'roles' => $this->roleRepository->getRoleNames(),
            'permissions' => $this->permissionRepository->getPermissionNames()
        ])->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        list($id, $grade, $specialty, $name) = explode('#', $request->user_war_name);
        $request['integration_id'] = $id;
        $request['pst_specialty'] = "{$grade} {$specialty}";
        $request['name'] = "{$name}";

        $data = $request->only('name', 'email', 'roles');

        if(!$this->userRepository->isValid($data)){
            return redirect()->route('user.create')
                ->withErrors($this->userRepository->getValidateErrors())
                ->withInput();
        }

        $user = $this->userRepository->create($request);

        $user->syncRoles($request->input('roles'));
        $user->syncPermissions($request->input('permissions'));

        if($request->has('only-save')){
            return redirect()->route('user.index')
                ->with($this->Message->success('Cadastro Concluído', 'Usuário cadastrado com sucesso!')->render());
        }
        return redirect()->route('user.create')
            ->with($this->Notify->success('Usuário cadastrado com sucesso!')->render());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function profile($id)
    {
        $data = [
            'category_name' => 'usuarios',
            'page_name' => 'profile_usuario',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $userRoles = $this->userRepository->getOwnRoles($id);

        return view('users.profile',[
            'user' => $this->userRepository->get($id),
            'permissions' => $this->permissionRepository->getPermissionNames(),
            'userPermissions' => $this->userRepository->getOwnPermissions($id),
            'inheritancePermissions' => $this->userRepository->getInheritancePermissions($id),
            'roles' => $this->roleRepository->getRoleNames(),
            'userRoles' => $userRoles,
        ])->with($data);
    }

    public function updateProfile(Request $request, $id)
    {
        if($request->has('roles')){
            $this->userRepository->get($id)->syncRoles($request->roles);
        } else {
            $request['roles'] = $this->userRepository->getOwnRoles($id);
        }
        if($request->has('permissions')){
            $this->userRepository->get($id)->syncPermissions($request->permissions);
        } else {
            $this->userRepository->getInheritancePermissions($id);
        }

        $data = $request->only('id', 'name', 'email', 'roles', 'password', 'password_confirmation');

        if(!$this->userRepository->isValid($data)){
            return redirect()->route('users.profile', $id)
                ->withErrors($this->userRepository->getValidateErrors())
                ->withInput();
        }

        $this->userRepository->update($request, $id);
        if($request['password']){
            $this->userRepository->setPassword($request['password'], $id);
        }

        if($request->has('only-save')){
            return redirect()->route('user.profile', $id)
                ->with($this->Notify->success('Seus dados foram atualizados com sucesso!')->render());
        }
        return redirect()->route('home')
            ->with($this->Message->success('Atualização Concluída', 'Seus dados foram atualizados com sucesso!')->render());

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'category_name' => 'usuarios',
            'page_name' => 'editar_usuario',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('users.edit',[
            'user' => $this->userRepository->get($id),
            'permissions' => $this->permissionRepository->getPermissionNames(),
            'userPermissions' => $this->userRepository->getOwnPermissions($id),
            'inheritancePermissions' => $this->userRepository->getInheritancePermissions($id),
            'roles' => $this->roleRepository->getRoleNames(),
            'userRoles' => $this->userRepository->getOwnRoles($id),
        ])->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only('id', 'name', 'email', 'roles');

        if(!$this->userRepository->isValid($data)){
            return redirect()->route('users.edit', $id)
                ->withErrors($this->userRepository->getValidateErrors())
                ->withInput();
        }

        $this->userRepository->update($request, $id);
        $this->userRepository->get($id)->syncRoles($request->roles);
        $this->userRepository->get($id)->syncPermissions($request->permissions);

        if($request->has('only-save')){
            return redirect()->route('user.edit', $id)
                ->with($this->Notify->success('Usuário atualizado com sucesso!')->render());
        }

        return redirect()->route('user.index')
            ->with($this->Message->success('Edição de Usuário', 'Usuário <b>'.$request->name. '</b> atualizado com sucesso!')->render());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userRepository->delete($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Exclusão concluída', 'Usuário excluído com sucesso!')->render();
        return response()->json($json);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $this->userRepository->restore($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Restauração concluída', 'Usuário restaurado com sucesso!')->render();
        return response()->json($json);
    }

    public function getDatatableActiveList(Request $request)
    {
        return response()->json($this->getDatatableList($request, [], [0,1,0,0,0,0,1]));
    }

    public function getDatatableDeletedList(Request $request)
    {
        return response()->json($this->getDatatableList($request, "trashed", [0,0,1,0,0,0,0]));
    }

    private function getDatatableList(Request $request, $condition, $buttons)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = $this->userRepository->getTotalRecords(null,null, $condition);
        $totalRecordswithFilter = $this->userRepository->getTotalRecords($searchValue, true, $condition);

        // Fetch records
        $records = $this->userRepository->getFilteredList($searchValue, $columnName, $columnSortOrder, $start, $rowperpage, $condition);

        $data_arr = [];
        $data_arr = $this->userRepository->getDataListActions($records, 'user', $buttons);

        $dataList = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return $dataList;
    }
}
