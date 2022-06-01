<?php

namespace App\Http\Controllers;

use App\Interfaces\IMotoristaRepository;
use App\Motorista;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MotoristaController extends Controller
{
    private $motoristaRepository;

    /**
     * @param $motoristaRepository
     */
    public function __construct(IMotoristaRepository $motoristaRepository)
    {
        parent::__construct();
        $this->motoristaRepository = $motoristaRepository;
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
        $motoristas = $this->motoristaRepository->list();

        return view('motoristas.index',[
            'motoristas' => $motoristas
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
            'category_name' => 'motorista',
            'page_name' => 'historico_motoristas',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        $motorista = $this->motoristaRepository->history();

        return view('motorista.history',[
            'motorista' => $motorista
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
            'category_name' => 'motorista',
            'page_name' => 'cadastrar_motorista',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $users = User::all();
        return view('motoristas.create',[
            'users' => $users
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
        $data = $request->only('user_id', 'cnh_number', 'cnh_category', 'cnh_validate', 'authorization_date', 'status');
        if(!$this->motoristaRepository->isValid($data)){
            return redirect()->route('motorista.create')
                ->withErrors($this->motoristaRepository->getValidateErrors())
                ->withInput();
        }

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
     * @param  \App\Motorista  $motorista
     * @return Response
     */
    public function edit(Motorista $motorista)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Motorista  $motorista
     * @return Response
     */
    public function update(Request $request, Motorista $motorista)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Motorista  $motorista
     * @return Response
     */
    public function destroy(Motorista $motorista)
    {
        //
    }
}
