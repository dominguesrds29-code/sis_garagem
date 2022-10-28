<?php

namespace App\Http\Controllers;

use App\Interfaces\IPermissionRepository;
use App\Interfaces\IRoleRepository;
use App\Support\DataList;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use DataList;

    /**
     * @var IPermissionRepository
     */
    private $permissionRepository;

    /**
     * @param $repository
     */
    public function __construct(
        IRoleRepository $repository,
        IPermissionRepository $permissionRepository
    )
    {
        parent::__construct();
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store','getDataList']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);

        $this->repository = $repository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'roles',
            'page_name' => 'listar_roles',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->repository->getFieldList());
        $config = $this->getConfig($this->repository->getFieldList(), 'roles.datatable_list');

        return view('roles.index',[
            'heads' => $heads,
            'config' => $config,
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
            'category_name' => 'roles',
            'page_name' => 'cadastrar_role',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('roles.create',[
            'permissions' => $this->permissionRepository->getPermissionNames()
        ])->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->only('name', 'permissions');

        if(!$this->repository->isValid($data)){
            return redirect()->route('role.create')
                ->withErrors($this->repository->getValidateErrors())
                ->withInput();
        }

        $role = $this->repository->create($request);
        $role->syncPermissions($request->permissions);
        if($request->has('only-save')){
            return redirect()->route('role.index')
                ->with($this->Message->success('Cadastro Concluído', 'Papel cadastrado com sucesso!')->render());
        }
        return redirect()->route('role.create')
            ->with($this->Notify->success('Papel cadastrado com sucesso!')->render());
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'category_name' => 'roles',
            'page_name' => 'edit_roles',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('roles.edit',[
            'role' => $this->repository->get($id),
            'permissions' => $this->permissionRepository->getPermissionNames(),
            'rolePermissions' => $this->repository->getOwnPermissions($id),
        ])->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->only('id', 'name', 'permissions');

        if(!$this->repository->isValid($data)){
            return redirect()->route('role.edit', $id)
                ->withErrors($this->repository->getValidateErrors())
                ->withInput();
        }

        $this->repository->update($request, $id);
        $this->repository->get($id)->syncPermissions($request->permissions);
        if($request->has('only-save')){
            return redirect()->route('role.edit', $id)
                ->with($this->Notify->success('Papel atualizado com sucesso!')->render());
        }

        return redirect()->route('role.index')
            ->with($this->Message->success('Edição de Papéis', 'Papel <b>'.$request->name. '</b> atualizado com sucesso!')->render());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Exclusão concluída', 'Papel excluído com sucesso!')->render();
        return response()->json($json);
    }

    public function getDataList(Request $request)
    {
        return response()->json($this->getDatatableList($request, [],[0,1,0,0,0,0,1]));
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
        $totalRecords = $this->repository->getTotalRecords(null,null, $condition);
        $totalRecordswithFilter = $this->repository->getTotalRecords($searchValue, true, $condition);

        // Fetch records
        $records = $this->repository->getFilteredList($searchValue, $columnName, $columnSortOrder, $start, $rowperpage, $condition);

        $data_arr = [];
        $data_arr = $this->repository->getDataListActions($records, 'role', $buttons);

        $dataList = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return $dataList;
    }
}
