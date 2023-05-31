<?php

namespace App\Http\Controllers;

use App\Interfaces\IPermissionRepository;
use App\Support\DataList;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use DataList;

    /**
     * @param $repository
     */
    public function __construct(IPermissionRepository $repository)
    {
        parent::__construct();
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','store','getDataList']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'permissions',
            'page_name' => 'listar_permissions',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->repository->getFieldList());
        $config = $this->getConfig($this->repository->getFieldList(), 'permission.datatable_list');

        return view('permissions.index',[
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
            'category_name' => 'permissions',
            'page_name' => 'cadastrar_permission',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('permissions.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name');

        if(!$this->repository->isValid($data)){
            return redirect()->route('permission.create')
                ->withErrors($this->repository->getValidateErrors())
                ->withInput();
        }

        $this->repository->create($request);
        if($request->has('only-save')){
            return redirect()->route('permission.index')
                ->with($this->Message->success('Cadastro Concluído', 'Permissão cadastrada com sucesso!')->render());
        }

        return redirect()->route('permission.create')
            ->with($this->Notify->success('Permissão cadastrada com sucesso!')->render());

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
            'category_name' => 'permissions',
            'page_name' => 'editar_permission',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('permissions.edit',[
            'permission' => $this->repository->get($id)
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
        $data = $request->only('id', 'name');

        if(!$this->repository->isValid($data)){
            return redirect()->route('permission.edit', $id)
                ->withErrors($this->repository->getValidateErrors())
                ->withInput();
        }

        $this->repository->update($request, $id);
        if($request->has('only-save')){
            return redirect()->route('permission.edit', $id)
                ->with($this->Notify->success('Permissão atualizada com sucesso!')->render());
        }

        return redirect()->route('permission.index')
            ->with($this->Message->success('Edição de Permissões', 'Permissão <b>'.$request->name. '</b> atualizada com sucesso!')->render());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Exclusão concluída', 'Permissão excluída com sucesso!')->render();
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
        $data_arr = $this->repository->getDataListActions($records, 'permission', $buttons);

        $dataList = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return $dataList;
    }
}
