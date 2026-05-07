<?php

namespace App\Http\Controllers;

use App\Interfaces\IMotoristaRepository;
use App\Interfaces\ISaidaViaturaRepository;
use App\Interfaces\IViaturaRepository;
use App\Support\DataList;
use Illuminate\Http\Request;

class SaidaViaturaController extends Controller
{
    use DataList;

    private $saidaViaturaRepository;
    private $viaturaRepository;
    private $motoristaRepository;

    /**
     * @param $saidaViaturaRepository
     */
    public function __construct(
        ISaidaViaturaRepository $saidaViaturaRepository,
        IViaturaRepository $viaturaRepository,
        IMotoristaRepository $motoristaRepository
    )
    {
        parent::__construct();
        $this->saidaViaturaRepository = $saidaViaturaRepository;
        $this->viaturaRepository = $viaturaRepository;
        $this->motoristaRepository = $motoristaRepository;

        $this->middleware('permission:saidaviatura-list-active|saidaviatura-list-desactive|saidaviatura-create|saidaviatura-edit|saidaviatura-delete', ['only' => ['index','history','store']]);
        $this->middleware('permission:saidaviatura-create', ['only' => ['create','store']]);
        $this->middleware('permission:saidaviatura-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:saidaviatura-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'saida_viatura',
            'page_name' => 'listar_saidaviaturas',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->saidaViaturaRepository->getFieldList());
        $config = $this->getConfig($this->saidaViaturaRepository->getFieldList(), 'saidaviatura.activeList');

        return view('saidaviaturas.index',[
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
            'category_name' => 'saida_viatura',
            'page_name' => 'historico_saidaviaturas',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $heads = $this->getHeads($this->saidaViaturaRepository->getFieldList());
        $config = $this->getConfig($this->saidaViaturaRepository->getFieldList(), 'saidaviatura.completeList');

        return view('saidaviaturas.history',[
            'heads' => $heads,
            'config' => $config
        ])->with($data);
    }

    /**
     * Display a chart of saida viaturas.
     *
     * @return Response
     */
    public function grafico()
    {
        $data = [
            'category_name' => 'saida_viatura',
            'page_name' => 'grafico_saidaviaturas',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $grafico_dados = \DB::table('saida_viaturas')
            ->select(\DB::raw('DATE_FORMAT(created_at, "%m/%Y") as data'), \DB::raw('count(id) as total'))
            ->whereNull('deleted_at')
            ->groupBy('data')
            ->orderBy(\DB::raw('MIN(created_at)'), 'asc')
            ->get();

        $datas = $grafico_dados->pluck('data')->toArray();
        $totais = $grafico_dados->pluck('total')->map(function($val) { return (int) $val; })->values()->toArray();

        return view('saidaviaturas.grafico', [
            'datas' => $datas,
            'totais' => $totais
        ])->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(int|null $id = null)
    {
        $data = [
            'category_name' => 'saida_viatura',
            'page_name' => 'cadastrar_saidaviatura',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('saidaviaturas.create',
        [
            'viaturas' => $this->viaturaRepository->listActive()->filter(function($viatura){
                return !$viatura->isOut();
            }),
            'getinId' => $id,
            'hodometro_saida' => $id ? $this->viaturaRepository->getKilometragem($id) : null,
            'motoristas' => $this->motoristaRepository->list()
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
        $data = $request->only('viatura_id', 'motorista_id', 'destino', 'hodometro_saida', 'hora_saida');
        if(!$this->saidaViaturaRepository->isValid($data)){
            return redirect()->route('saidaviatura.create')
                        ->withErrors($this->saidaViaturaRepository->getValidateErrors())
                        ->withInput();
        }
        $request['status'] = 1;

        $this->saidaViaturaRepository->create($request);
        if($request->has('only-save')){
            return redirect()->route('saidaviatura.index')
                ->with($this->Message->success('Registro Concluído', 'Saída de Viatura cadastrada com sucesso!')->render());
        }

        return redirect()->route('saidaviatura.create')
            ->with($this->Notify->success('Saída de Viatura cadastrada com sucesso!')->render());
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id)
    {
        $data = [
            'category_name' => 'saida_viatura',
            'page_name' => 'editar_saidaviatura',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('saidaviaturas.edit', [
            'saida_viatura' => $this->saidaViaturaRepository->get($id),
            'viaturas' => $this->viaturaRepository->listActive(),
            'motoristas' => $this->motoristaRepository->list()
        ])->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function return(int $id)
    {
        if($saida = $this->saidaViaturaRepository->get($id)){
            if($saida->status == 0){
                return redirect()->route('saidaviatura.history')
                    ->with($this->Notify->info('Registro já finalizado!')->render());
            }
        } else {
            return redirect()->route('saidaviatura.index')
                ->with($this->Notify->error('Registro não encontrado!')->render());
        }

        $data = [
            'category_name' => 'saida_viatura',
            'page_name' => 'retornar_saidaviatura',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('saidaviaturas.return', [
            'saida_viatura' => $this->saidaViaturaRepository->get($id),
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
        $data = $request->only('id','viatura_id', 'motorista_id', 'destino', 'hodometro_saida', 'hora_saida');
        if(!$this->saidaViaturaRepository->isValid($data)){
            return redirect()->route('saidaviatura.edit', $id)
                ->withErrors($this->saidaViaturaRepository->getValidateErrors())
                ->withInput();
        }
        $request['status'] = 1;

        $this->saidaViaturaRepository->update($request, $id);
        if($request->has('onlyEdit')){
            return redirect()->route('saidaviatura.edit', $id)
                ->with($this->Notify->success('Registro de saída atualizado com sucesso!')->render());
        }
        return redirect()->route('saidaviatura.index')
            ->with($this->Message->success('Atualização Concluída', 'Registro de saída atualizado com sucesso!')->render());

    }

    public function storeReturn(Request $request, $id)
    {
        $data = $request->only('id', 'viatura_id', 'motorista_id', 'destino', 'hodometro_saida', 'hora_saida', 'hodometro_retorno', 'hora_retorno');
        if(!$this->saidaViaturaRepository->isValid($data)){
            return redirect()->route('saidaviatura.return', $id)
                ->withErrors($this->saidaViaturaRepository->getValidateErrors())
                ->withInput();
        }

        $request['status'] = 0;
        $this->viaturaRepository->updateKilometragem($request->hodometro_retorno, $request->viatura_id);

        $this->saidaViaturaRepository->update($request, $id);

        return redirect()->route('saidaviatura.history')
            ->with($this->Message->success('Retorno Concluído', 'Registro de saída finalizado com sucesso!')->render());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->saidaViaturaRepository->delete($id);

        $json['id'] = $id;
        $json['message'] = $this->Message->success('Exclusão concluída', 'Registro de Saída de Viatura excluído com sucesso!')->render();
        return response()->json($json);
    }

    public function getDatatableActiveList(Request $request)
    {
        return response()->json($this->getDatatableList($request, ['status' => 1],[0,1,1,0,0,0,0,1]));
    }

    public function getDatatableCompleteList(Request $request)
    {
        return response()->json($this->getDatatableList($request, ['status' => 0], [0,0,0,0,0,0,0,0]));
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
        $totalRecords = $this->saidaViaturaRepository->getTotalRecords(null,null, $condition);
        $totalRecordswithFilter = $this->saidaViaturaRepository->getTotalRecords($searchValue, true, $condition);

        // Fetch records
        $records = $this->saidaViaturaRepository->getFilteredList($searchValue, $columnName, $columnSortOrder, $start, $rowperpage, $condition);

        $data_arr = [];
        $data_arr = $this->saidaViaturaRepository->getDataListActions($records, 'saidaviatura', $buttons);

        $dataList = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return $dataList;
    }

    public function apiIndex()
    {
        return response()->json($this->saidaViaturaRepository->listActive()->map(function ($item){
            return [
                'id' => $item->id,
                'viatura' => $item->viatura->modelo,
                'motorista' => $item->motorista->user_war_name,
                'destino' => $item->destino,
                'hodometro_saida' => $item->hodometro_saida,
                'hora_saida' => $item->hora_saida,
            ];
        }));
    }

    public function apiStore(Request $request)
    {
        $data = $request->only('viatura_id', 'motorista_id', 'destino', 'hodometro_saida', 'hora_saida');
        if (!$this->saidaViaturaRepository->isValid($data)) {
            return response()->json(
                [
                    'has_error' => true,
                    'messages' => $this->saidaViaturaRepository->getValidateErrors()->errors()
                ]
                , 200);
        }
        $request['status'] = 1;
        $this->saidaViaturaRepository->create($request);
        return response()->json([
                    'has_error' => false,
                    'errors' => []
                ]
                , 200);
    }

    public function apiStoreReturn(Request $request)
    {
        $saidaViatura = $this->saidaViaturaRepository->get($request->id);

        if($saidaViatura->status == 0){
            return response()->json(
                [
                    'has_error' => true,
                    'messages' => [['Registro já finalizado!']]
                ]
                , 200);
        }

        $data = [
            'id' => $request->id,
            'viatura_id' => $saidaViatura->viatura_id,
            'motorista_id' => $saidaViatura->motorista_id,
            'destino' => $saidaViatura->destino,
            'hodometro_saida' => $saidaViatura->hodometro_saida,
            'hora_saida' => $saidaViatura->hora_saida,
            'hodometro_retorno' => $request->hodometro_retorno,
            'hora_retorno' => $request->hora_retorno
        ];

        if (!$this->saidaViaturaRepository->isValid($data)) {
            return response()->json(
                [
                    'has_error' => true,
                    'messages' => $this->saidaViaturaRepository->getValidateErrors()->errors()
                ]
                , 200);
        }

        $this->viaturaRepository->updateKilometragem($request->hodometro_retorno, $saidaViatura->viatura_id);
        $saidaViatura->status = 0;
        $saidaViatura->hodometro_retorno = $request->hodometro_retorno;
        $saidaViatura->hora_retorno = $request->hora_retorno;
        $saidaViatura->save();

        return response()->json([
                    'has_error' => false,
                    'errors' => []
                ]
                , 200);
    }
}
