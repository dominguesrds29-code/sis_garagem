<?php

namespace App\Http\Controllers;

use App\Interfaces\IMotoristaRepository;
use App\Motorista;
use App\Services\Efetivo\GetEffectiveList;
use App\Support\DataList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MotoristaController extends Controller
{
    use DataList;

    private $motoristaRepository;

    /**
     * @param $motoristaRepository
     */
    public function __construct(IMotoristaRepository $motoristaRepository)
    {
        parent::__construct();
        $this->motoristaRepository = $motoristaRepository;

        $this->middleware('permission:driver-list-active|driver-list-desactive|driver-create|driver-edit|driver-delete|driver-active|driver-desactive', ['only' => ['index','history','store']]);
        $this->middleware('permission:driver-create', ['only' => ['create','store']]);
        $this->middleware('permission:driver-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:driver-active', ['only' => ['activate','getDatatableDesactiveList']]);
        $this->middleware('permission:driver-desactive', ['only' => ['desactivate','getDatatableActiveList']]);
        $this->middleware('permission:driver-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'motoristas',
            'page_name' => 'listar_motoristas',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->motoristaRepository->getFieldList());
        $config = $this->getConfig($this->motoristaRepository->getFieldList(), 'motorista.activeList');
        //$motoristas = $this->motoristaRepository->listActive();

        return view('motoristas.index',[
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
            'category_name' => 'motoristas',
            'page_name' => 'historico_motoristas',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->motoristaRepository->getFieldList());
        $config = $this->getConfig($this->motoristaRepository->getFieldList(), 'motorista.inactiveList');

        return view('motoristas.history',[
            'heads' => $heads,
            'config' => $config
        ])->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'category_name' => 'motoristas',
            'page_name' => 'cadastrar_motorista',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $users = (new GetEffectiveList())->call();
        return view('motoristas.create',[
            'users' => $users ?? []
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
        $data = $request->only('user_war_name', 'cnh_number', 'cnh_category', 'cnh_validate', 'authorization_date');

        if(!$this->motoristaRepository->isValid($data)){
            return redirect()->route('motorista.create')
                ->withErrors($this->motoristaRepository->getValidateErrors())
                ->withInput();
        }

        $request['user_id'] = explode('#', $request['user_war_name'])[0];
        $request['user_war_name'] = explode('#', $request['user_war_name'])[1];

        $this->motoristaRepository->create($request);
        return redirect()->route('motorista.index')
            ->with($this->Notify->success('Motorista cadastrado com sucesso!')->render());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Motorista  $motorista
     * @return Response
     */
    public function show(Motorista $motorista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $motorista_id
     * @return Response
     */
    public function edit($motorista_id)
    {
        $motorista = $this->motoristaRepository->get($motorista_id);

        $data = [
            'category_name' => 'motoristas',
            'page_name' => 'editar_motorista',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('motoristas.edit',[
            'motorista' => $motorista
        ])->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $motorista_id
     * @return Response
     */
    public function update(Request $request, $motorista_id)
    {
        $data = $request->only('id','user_war_name', 'cnh_number', 'cnh_category', 'cnh_validate', 'authorization_date');

        if(!$this->motoristaRepository->isValid($data)){
            return redirect()->route('motorista.edit', $motorista_id)
                ->withErrors($this->motoristaRepository->getValidateErrors())
                ->withInput();
        }

        $this->motoristaRepository->update($request, $motorista_id);
        if($request->has('onlyEdit')){
            return redirect()->route('motorista.edit', $motorista_id)
                ->with($this->Notify->success('Motorista atualizado com sucesso!')->render());
        } else {
            return redirect()->route('motorista.index')
                ->with($this->Notify->success('Motorista atualizado com sucesso!')->render());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->motoristaRepository->delete($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Exclusão concluída', 'Autorização excluída com sucesso!')->render();
        return response()->json($json);
    }

    /**
     * Reactive the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate($id)
    {
        if(!$this->motoristaRepository->active($id)){
            $json['message'] = $this->Message->error('Erro na Reativação', 'Validade da Autorização ou CNH vencida(s)!')->render();
            return response()->json($json);
        }

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Reativação concluída', 'Autorização ativada com sucesso!')->render();
        return response()->json($json);
    }

    /**
     * Reactive the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function desactivate($id)
    {
        $this->motoristaRepository->desactive($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Dasativação concluída', 'Autorização desativada com sucesso!')->render();
        return response()->json($json);
    }

    public function getDatatableActiveList(Request $request)
    {
        return response()->json($this->getDatatableList($request, ['status' => Motorista::AUTHORIZATION_ACTIVE], [0,1,0,1,0,0,1]));
    }

    public function getDatatableDesactiveList(Request $request)
    {
        return response()->json($this->getDatatableList($request, ['status' => Motorista::AUTHORIZATION_INACTIVE], [0,0,1,0,0,0,0]));
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
        $totalRecords = $this->motoristaRepository->getTotalRecords(null,null, $condition);
        $totalRecordswithFilter = $this->motoristaRepository->getTotalRecords($searchValue, true, $condition);

        // Fetch records
        $records = $this->motoristaRepository->getFilteredList($searchValue, $columnName, $columnSortOrder, $start, $rowperpage, $condition);

        $data_arr = [];
        $data_arr = $this->motoristaRepository->getDataListActions($records, 'motorista', $buttons);

        $dataList = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return $dataList;
    }

    public function motoristaList()
    {
        return response()->json($this->motoristaRepository->apiMotoristasList());
    }
}
