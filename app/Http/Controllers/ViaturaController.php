<?php

namespace App\Http\Controllers;

use App\Interfaces\IViaturaRepository;
use App\Viatura;
use Illuminate\Http\Request;

class ViaturaController extends Controller
{
    private $viaturaRepository;

    /**
     * @param $viaturaRepository
     */
    public function __construct(IViaturaRepository $viaturaRepository)
    {
        $this->viaturaRepository = $viaturaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Viatura  $viatura
     * @return \Illuminate\Http\Response
     */
    public function show(Viatura $viatura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Viatura  $viatura
     * @return \Illuminate\Http\Response
     */
    public function edit(Viatura $viatura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Viatura  $viatura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Viatura $viatura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Viatura  $viatura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Viatura $viatura)
    {
        //
    }

    /**
     * Solicitar Viatura
     *
     * @param  \App\Viatura  $viatura
     * @return \Illuminate\Http\Response
     */
    public function solicitarViatura(Viatura $viatura)
    {
        $data = [
            'category_name' => 'viatura',
            'page_name' => 'solicitar_viatura',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        return view('viaturas.request')->with($data);
    }


}
