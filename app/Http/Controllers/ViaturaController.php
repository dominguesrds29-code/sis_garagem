<?php

namespace App\Http\Controllers;

use App\Interfaces\IViaturaRepository;
use App\Support\DataList;
use App\Viatura;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ViaturaController extends Controller
{
    use DataList;

    private $viaturaRepository;

    /**
     * @param $viaturaRepository
     */
    public function __construct(
        IViaturaRepository $viaturaRepository
    )
    {
        parent::__construct();
        $this->viaturaRepository = $viaturaRepository;

        $this->middleware('permission:viatura-list-active|viatura-list-desactive|viatura-create|viatura-edit|viatura-delete|viatura-active|viatura-desactive', ['only' => ['index','history','store']]);
        $this->middleware('permission:viatura-create', ['only' => ['create','store']]);
        $this->middleware('permission:viatura-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:viatura-active', ['only' => ['activate','getDatatableDesactiveList']]);
        $this->middleware('permission:viatura-desactive', ['only' => ['desactivate','getDatatableActiveList']]);
        $this->middleware('permission:viatura-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'viatura',
            'page_name' => 'listar_viaturas',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->viaturaRepository->getFieldList());
        $config = $this->getConfig($this->viaturaRepository->getFieldList(), 'viatura.activeList');

        return view('viaturas.index',[
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
            'category_name' => 'viatura',
            'page_name' => 'historico_viaturas',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $heads = $this->getHeads($this->viaturaRepository->getFieldList());
        $config = $this->getConfig($this->viaturaRepository->getFieldList(), 'viatura.inactiveList');

        return view('viaturas.history',[
            'heads' => $heads,
            'config' => $config
        ])->with($data);
    }

    /**
     * Display a chart of viaturas usage.
     *
     * @return Response
     */
    public function grafico()
    {
        $data = [
            'category_name' => 'viatura',
            'page_name' => 'grafico_viaturas',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $grafico_dados = \DB::table('saida_viaturas')
            ->join('viaturas', 'saida_viaturas.viatura_id', '=', 'viaturas.id')
            ->select('viaturas.modelo', \DB::raw('count(saida_viaturas.id) as total'))
            ->whereNull('saida_viaturas.deleted_at')
            ->groupBy('viaturas.id', 'viaturas.modelo')
            ->get();

        $modelos = $grafico_dados->pluck('modelo')->toArray();
        $totais = $grafico_dados->pluck('total')->map(function($val) { return (int) $val; })->values()->toArray();

        return view('viaturas.grafico', [
            'modelos' => $modelos,
            'totais' => $totais
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
            'category_name' => 'viatura',
            'page_name' => 'cadastrar_viatura',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('viaturas.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->only('modelo', 'combustivel', 'situacao');
        if(!$this->viaturaRepository->isValid($data)){
            return redirect()->route('viatura.create')
                        ->withErrors($this->viaturaRepository->getValidateErrors())
                        ->withInput();
        }

        $this->viaturaRepository->create($request);
        if($request->has('only-save')){
            return redirect()->route('viatura.index')
                ->with($this->Message->success('Cadastro Concluído', 'Viatura cadastrada com sucesso!')->render());
        }

        return redirect()->route('viatura.create')
            ->with($this->Notify->success('Viatura cadastrada com sucesso!')->render());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Viatura  $viatura
     * @return Response
     */
    public function show(Viatura $viatura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Viatura  $viatura
     * @return Response
     */
    public function edit(Viatura $viatura)
    {
        $data = [
            'category_name' => 'viatura',
            'page_name' => 'cadastrar_viatura',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('viaturas.edit', [
            'viatura' => $viatura
        ])->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only('id','modelo', 'combustivel', 'situacao');
        if(!$this->viaturaRepository->isValid($data)){
            return redirect()->route('viatura.create')
                ->withErrors($this->viaturaRepository->getValidateErrors())
                ->withInput();
        }

        $this->viaturaRepository->update($request, $id);
        if($request->has('onlyEdit')){
            return redirect()->route('viatura.edit', $id)
                ->with($this->Notify->success('Viatura atualizada com sucesso!')->render());
        }
        return redirect()->route('viatura.index')
            ->with($this->Message->success('Atualização Concluída', 'Viatura atualizada com sucesso!')->render());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->viaturaRepository->delete($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Exclusão concluída', 'Viatura excluída com sucesso!')->render();
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
        $this->viaturaRepository->active($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Reativação concluída', 'Viatura ativada com sucesso!')->render();
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
        $this->viaturaRepository->desactive($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Dasativação concluída', 'Viatura desatidada com sucesso!')->render();
        return response()->json($json);
    }

    public function getDatatableActiveList(Request $request)
    {
        return response()->json($this->getDatatableList($request, ['situacao' => Viatura::ACTIVE],[0,1,0,1,0,0,1]));
    }

    public function getDatatableDesactiveList(Request $request)
    {
        return response()->json($this->getDatatableList($request, ['situacao' => Viatura::INACTIVE], [0,0,1,0,0,0,0]));
    }

    public function getKilometragem($id)
    {
        return response()->json(['kilometragem' => $this->viaturaRepository->getKilometragem($id)]);
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
        $totalRecords = $this->viaturaRepository->getTotalRecords(null,null, $condition);
        $totalRecordswithFilter = $this->viaturaRepository->getTotalRecords($searchValue, true, $condition);

        // Fetch records
        $records = $this->viaturaRepository->getFilteredList($searchValue, $columnName, $columnSortOrder, $start, $rowperpage, $condition);

        $data_arr = [];
        $data_arr = $this->viaturaRepository->getDataListActions($records, 'viatura', $buttons);

        $dataList = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return $dataList;
    }

    public function viaturaList()
    {
        return response()->json($this->viaturaRepository->apiListActive());
    }
}
