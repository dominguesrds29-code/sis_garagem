<?php

namespace App\Http\Controllers;

use App\Interfaces\IMotoristaRepository;
use App\Interfaces\IRequestRepository;
use App\Interfaces\IViaturaRepository;
use App\Services\Efetivo\GetUserData;
use App\Solicitacao;
use App\Support\DataList;
use App\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class SolicitacaoController extends Controller
{
    use DataList;

    private $motoristaRepository;
    private $viaturaRepository;
    private $requestRepository;

    /**
     * @param $motoristaRepository
     * @param $viaturaRepository
     */
    public function __construct(
        IRequestRepository   $requestRepository,
        IMotoristaRepository $motoristaRepository,
        IViaturaRepository   $viaturaRepository
    )
    {
        parent::__construct();
        $this->requestRepository = $requestRepository;
        $this->motoristaRepository = $motoristaRepository;
        $this->viaturaRepository = $viaturaRepository;

        $this->middleware('permission:request-list-pending|request-create|request-edit|request-delete', [
            'only' => [ 'index','store']
        ]);
        $this->middleware('permission:request-list-preapproved', ['only' => ['preauthorized']]);
        $this->middleware('permission:request-list-approved', ['only' => ['authorized']]);
        $this->middleware('permission:request-list-reproved', ['only' => ['reproved']]);
        $this->middleware('permission:request-list-archived', ['only' => ['history']]);
        $this->middleware('permission:request-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:request-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:request-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of pending the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'category_name' => 'solicitacoes',
            'page_name' => 'listar_solicitacoes',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->requestRepository->getFieldList());
        $config = $this->getConfig($this->requestRepository->getFieldList(), 'solicitacao.pendingList', [2, 'desc']);
        //$solicitacoes = $this->requestRepository->list();

        return view('solicitacoes.index', [
            'heads' => $heads,
            'config' => $config
        ])->with($data);
    }

    /**
     * Display a listing of preauthorized the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function preauthorized()
    {
        $data = [
            'category_name' => 'solicitacoes',
            'page_name' => 'listar_solicitacoes_ass',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->requestRepository->getFieldList());
        $config = $this->getConfig($this->requestRepository->getFieldList(), 'solicitacao.authList', [2, 'desc']);
        //$solicitacoes = $this->requestRepository->list();

        return view('solicitacoes.index', [
            'heads' => $heads,
            'config' => $config
        ])->with($data);
    }

    /**
     * Display a listing of authorized the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authorized()
    {
        $data = [
            'category_name' => 'solicitacoes',
            'page_name' => 'listar_solicitacoes_ass_ch',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->requestRepository->getFieldList());
        $config = $this->getConfig($this->requestRepository->getFieldList(), 'solicitacao.authChList', [2, 'desc']);
        //$solicitacoes = $this->requestRepository->list();

        return view('solicitacoes.index', [
            'heads' => $heads,
            'config' => $config
        ])->with($data);
    }

    /**
     * Display a listing of reproved the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reproved()
    {
        $data = [
            'category_name' => 'solicitacoes',
            'page_name' => 'listar_solicitacoes_rp',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->requestRepository->getFieldList());
        $config = $this->getConfig($this->requestRepository->getFieldList(), 'solicitacao.authRpList', [2, 'desc']);
        //$solicitacoes = $this->requestRepository->list();

        return view('solicitacoes.index', [
            'heads' => $heads,
            'config' => $config
        ])->with($data);
    }

    /**
     * Display a listing of history the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $data = [
            'category_name' => 'solicitacoes',
            'page_name' => 'historico_solicitacoes',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $heads = $this->getHeads($this->requestRepository->getFieldList(true));
        $config = $this->getConfig($this->requestRepository->getFieldList(true), 'solicitacao.historyList', [2, 'desc']);
        //$solicitacoes = $this->requestRepository->list();

        return view('solicitacoes.history', [
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
            'category_name' => 'solicitacoes',
            'page_name' => 'cadastrar_solicitacao',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('solicitacoes.create', [
            'drivers' => $this->motoristaRepository->list(),
            'viaturas' => $this->viaturaRepository->listActive()
        ])->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('dt_inicio', 'hora_inicio', 'dt_final', 'hora_final', 'viatura_id', 'motorista_id', 'destino', 'missao', 'itinerario');

        if (!$this->requestRepository->isValid($data)) {
            return redirect()->route('solicitacao.create')
                ->withErrors($this->requestRepository->getValidateErrors())
                ->withInput();
        }

        $this->requestRepository->create($request);
        return redirect()->route('solicitacao.index')
            ->with($this->Notify->success('Solicitação cadastrada com sucesso!')->render());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $solicitacao)
    {
        $data = [
            'category_name' => 'solicitacoes',
            'page_name' => 'visualizar_solicitacao',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('solicitacoes.view', [
            'solicitacao' => $this->requestRepository->get($solicitacao),
        ])->with($data);
    }

    /**
     * Print the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function print(int $id)
    {
        $solicitacao = $this->requestRepository->get($id);
        $motorista = (new GetUserData($solicitacao->motorista->user_id))->call();
        $pdf = Pdf::loadView('solicitacoes.print', [
            'solicitacao' => $solicitacao,
            'motorista' => $motorista]);
        return $pdf->stream();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $solicitacao
     * @return \Illuminate\Http\Response
     */
    public function edit(int $solicitacao)
    {
        $data = [
            'category_name' => 'solicitacoes',
            'page_name' => 'editar_solicitacao',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('solicitacoes.edit', [
            'drivers' => $this->motoristaRepository->list(),
            'viaturas' => $this->viaturaRepository->listActive(),
            'solicitacao' => $this->requestRepository->get($solicitacao),
        ])->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $solicitacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $solicitacao)
    {
        $data = $request->only('dt_inicio', 'hora_inicio', 'dt_final', 'hora_final', 'viatura_id', 'motorista_id', 'destino', 'missao', 'itinerario');

        if (!$this->requestRepository->isValid($data)) {
            return redirect()->route('solicitacao.edit', $solicitacao)
                ->withErrors($this->requestRepository->getValidateErrors())
                ->withInput();
        }

        $this->requestRepository->update($request, $solicitacao);
        if ($request->has('onlyEdit')) {
            return redirect()->route('solicitacao.edit', $solicitacao)
                ->with($this->Notify->success('Solicitação atualizada com sucesso!')->render());
        } else {
            return redirect()->route('solicitacao.index')
                ->with($this->Notify->success('Solicitação atualizada com sucesso!')->render());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $this->requestRepository->delete($id);
        $json['id'] = $id;
        $json['message'] = $this->Message->success('Exclusão concluída', 'Solicitação excluída com sucesso!')->render();
        return response()->json($json);
    }

    /**
     * Approve the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve($id)
    {
        $logged = User::find(auth()->user()->id);
        if ($logged->can('request-approve-chief')) {
            $this->requestRepository->commissionerApprove($id);
            $this->requestRepository->chiefApprove($id);
            $json['id'] = $id;
            $json['message'] = $this->Message->success('Aprovação concluída', 'Solicitação aprovada com sucesso!')->render();
            return response()->json($json);
        } elseif ($logged->can('request-approve-commissioner')) {
            $this->requestRepository->commissionerApprove($id);
            $json['id'] = $id;
            $json['message'] = $this->Message->success('Aprovação concluída', 'É necessária ainda a aprovação do Chefe!')->render();
            return response()->json($json);
        }

        $json['message'] = $this->Message->error('Erro na Aprovação', 'Ocorreu um erro durante a aprovação. Favor checar se possui pemissão para esta operação!')->render();
        return response()->json($json);
    }

    /**
     * Desapprove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function desapprove($id)
    {
        $logged = User::find(auth()->user()->id);
        if ($logged->can('request-desapprove-chief')) {
            $this->requestRepository->commissionerDesapprove($id);
            $this->requestRepository->chiefDespprove($id);
            $json['id'] = $id;
            $json['message'] = $this->Message->success('Reprovação concluída', 'Solicitação reprovada com sucesso!')->render();
            return response()->json($json);
        } elseif ($logged->can('request-desapprove-commissioner')) {
            $this->requestRepository->commissionerDesapprove($id);
            $json['id'] = $id;
            $json['message'] = $this->Message->success('Reprovação concluída', 'É necessária ainda a reprovação do Chefe!')->render();
            return response()->json($json);
        }

        $json['message'] = $this->Message->error('Erro na Reprovação', 'Ocorreu um erro durante a reprovação. Favor checar se possui pemissão para esta operação!')->render();
        return response()->json($json);
    }

    /**
     * Archive the specified resource from storage.
     *
     * @param int $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(Request $request, $id)
    {
        $this->requestRepository->setMissionStatus($id, $request->opt);
        $this->requestRepository->arquivar($id);
        $json['id'] = $id;
        $json['message'] = $this->Message->success('Arquivamento concluído', 'Solicitação arquivada com sucesso!')->render();
        return response()->json($json);
    }

    public function getDatatablePendingList(Request $request)
    {
        return response()->json($this->getDatatableList($request, [['encarregado', null], ['chefe', null]], [1, 1, 1, 1, 0, 0, 1]));
    }

    public function getDatatableAuthList(Request $request)
    {
        return response()->json($this->getDatatableList($request, [['encarregado', '<>', null], ['chefe', null]], [1, 0, 1, 1, 0, 0, 0]));
    }

    public function getDatatableAuthChList(Request $request)
    {
        return response()->json($this->getDatatableList($request, [['chefe', '<>', null], ['chefe_aut', 1], ['arquivo', null]], [1, 0, 0, 0, 1, 1, 0]));
    }

    public function getDatatableAuthRpList(Request $request)
    {
        return response()->json($this->getDatatableList($request, [['chefe', '<>', null], ['chefe_aut', 2], ['arquivo', null]], [1, 0, 0, 0, 0, 1, 0]));
    }

    public function getDatatableHistoryList(Request $request)
    {
        return response()->json($this->getDatatableList($request, [['arquivo', '<>', null]], [1, 0, 0, 0, 1, 0, 0]));
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
        $totalRecords = $this->requestRepository->getTotalRecords(null, null, $condition);
        $totalRecordswithFilter = $this->requestRepository->getTotalRecords($searchValue, true, $condition);

        // Fetch records
        $records = $this->requestRepository->getFilteredList($searchValue, $columnName, $columnSortOrder, $start, $rowperpage, $condition);

        $data_arr = [];
        $data_arr = $this->requestRepository->getDataListActions($records, 'solicitacao', $buttons);

        $dataList = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return $dataList;
    }

    public function apiIndex($id)
    {
        return $this->requestRepository->conditionalList([['user_id', $id]]);
    }

    public function apiStore(Request $request)
    {
        $data = $request->only('dt_inicio', 'hora_inicio', 'dt_final', 'hora_final', 'viatura_id', 'motorista_id', 'destino', 'missao', 'itinerario');

        if (!$this->requestRepository->isValid($data)) {
            return response()->json(false, 400);
        }

        $this->requestRepository->create($request);
        return response()->json(true, 200);
    }
}
