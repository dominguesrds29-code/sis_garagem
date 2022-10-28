@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/flatpickr.css') }}">
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-spacing layout-top-spacing">
            <div class="col-lg-12">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Visualizar Solicitação de Viatura</h4>
                </div>
                <div class="widget-content widget-content-area">
                    <form name="viewSolicViatura">
                        <div class="form-row mb-2">
                            <div class="form-group col-md-3">
                                <label>Data de Início:</label>
                                <div class="form-control">{{  date('d/m/Y', strtotime($solicitacao->dt_inicio)) }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Hora de Início:</label>
                                <div class="form-control">{{ $solicitacao->hora_inicio }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Data de Término:</label>
                                <div class="form-control">{{ date('d/m/Y', strtotime($solicitacao->dt_final)) }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Hora de Término:</label>
                                <div class="form-control">{{ $solicitacao->hora_final }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Viatura</label>
                                <div class="form-control">{{ $solicitacao->viatura->modelo }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nome do Motorista</label>
                                <div class="form-control">{{ $solicitacao->motorista->user_war_name }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Destino</label>
                                <div class="form-control">{{ $solicitacao->destino }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Itinerário</label>
                                <div class="form-control">{{ $solicitacao->itinerario }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Missão</label>
                                <div class="form-control">{{ $solicitacao->missao }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Passageiros</label>
                                <div class="form-control">{{ $solicitacao->passageiros }}</div>
                            </div>
                        </div>
                        <div class="form-group col-md-2 offset-md-10">
                            <a class="btn btn-danger" href="#" onClick="history.back()">Sair</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
