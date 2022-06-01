<?php

namespace App\Http\Controllers;

use App\Interfaces\IViaturaRepository;
use App\Viatura;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ViaturaController extends Controller
{
    private $viaturaRepository;

    /**
     * @param $viaturaRepository
     */
    public function __construct(IViaturaRepository $viaturaRepository)
    {
        parent::__construct();
        $this->viaturaRepository = $viaturaRepository;
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
        $viaturas = $this->viaturaRepository->list();

        return view('viaturas.index',[
            'viaturas' => $viaturas
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
        $viaturas = $this->viaturaRepository->history();

        return view('viaturas.history',[
            'viaturas' => $viaturas
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
        $data = $request->only('modelo', 'combustivel', 'situacao', 'kilometragem');
        if(!$this->viaturaRepository->isValid($data)){
            return redirect()->route('viatura.create')
                        ->withErrors($this->viaturaRepository->getValidateErrors())
                        ->withInput();
        }

        $this->viaturaRepository->create($request);
        return redirect()->route('viatura.index')
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
        $data = $request->only('modelo', 'combustivel', 'situacao', 'kilometragem');
        if(!$this->viaturaRepository->isValid($data)){
            return redirect()->route('viatura.create')
                ->withErrors($this->viaturaRepository->getValidateErrors())
                ->withInput();
        }

        $this->viaturaRepository->update($request, $id);
        return redirect()->route('viatura.edit', $id)
            ->with($this->Notify->success('Viatura atualizada com sucesso!')->render());
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
     * Solicitar Viatura
     *
     * @param  \App\Viatura  $viatura
     * @return Response
     */
    public function solicitarViatura(Viatura $viatura)
    {
        $data = [
            'category_name' => 'viatura',
            'page_name' => 'solicitar_viatura',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return response()->view('viaturas.request')->with($data);
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


}
