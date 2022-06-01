@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
@endsection

@section('content')
        <div class="layout-px-spacing">
            <div class="row layout-spacing layout-top-spacing">
                <div class="col-lg-12">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Cadastro de Viaturas</h4>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form name="cadViatura" method='post' action="{{ route('viatura.store') }}">
                            @csrf
                            @method('POST')
                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label>Modelo</label>
                                    <input type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" placeholder="Modelo">

                                    @error('modelo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                            </div>
                            <div class="form-row mb-2">
                                <div class="form-group col-md-5">
                                    <label>Tipo de Combustível</label>
                                    <select class="form-control tagging @error('combustivel') is-invalid @enderror" name="combustivel[]" multiple="multiple">
                                        <option value="Gasolina">Gasolina</option>
                                        <option value="Etanol">Etanol</option>
                                        <option value="Diesel">Diesel</option>
                                    </select>

                                    @error('combustivel')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                           
                                <div class="form-group col-md-4">
                                    <label>Situação</label>                            
                                    <select class="placeholder js-states form-control @error('situacao') is-invalid @enderror" name="situacao">
                                        <option value="">Selecione uma opção...</option>
                                        <option value="Ativa">Ativa</option>
                                        <option value="Recolhida">Recolhida</option>
                                    </select>

                                    @error('situacao')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Kilometragem Inicial</label>
                                    <input type="tel" class="form-control @error('kilometragem') is-invalid @enderror" name="kilometragem" placeholder="Kilometragem">

                                    @error('kilometragem')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                          
                            </div> 
                            <div class="form-group col-md-3 offset-md-9">
                                <button class="btn btn-primary mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> Cadastrar
                                </button>
                                <a class="btn btn-danger" href="{{ route('viatura.index') }}">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('js')
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script>
    $(".tagging").select2({
        tags: true,
        maximumSelectionLength: 2
    });
</script>
@endsection
