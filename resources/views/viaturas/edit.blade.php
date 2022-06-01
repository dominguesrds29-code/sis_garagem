@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
@endsection

@section('content')
        <div class="layout-px-spacing">
            <div class="row layout-spacing layout-top-spacing">
                <div class="col-lg-12">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Editar Viatura</h4>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form name="editViatura" method='post' action="{{ route('viatura.update', $viatura->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label>Modelo</label>
                                    <input type="text" class="form-control @error('modelo') is-invalid @enderror"
                                           name="modelo" placeholder="Modelo" value="{{ old('modelo') ?? $viatura->modelo }}">

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
                                    <select class="form-control tagging @error('combustivel') is-invalid @enderror"
                                            name="combustivel[]" multiple="multiple">
                                        <option value="Gasolina"{{ old('combustivel') == 'Gasolina' ? ' selected' : (in_array('Gasolina', $viatura->ex_combustivel) ? ' selected' : '') }}>Gasolina</option>
                                        <option value="Etanol"{{ old('combustivel') == 'Etanol' ? ' selected' : (in_array('Etanol', $viatura->ex_combustivel) ? ' selected' : '') }}>Etanol</option>
                                        <option value="Diesel"{{ old('combustivel') == 'Diesel' ? ' selected' : (in_array('Diesel', $viatura->ex_combustivel) ? ' selected' : '') }}>Diesel</option>
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
                                        <option value="Ativa"{{ old('situacao') == 'Ativa' ? ' selected' : ($viatura->situacao == 'Ativa' ? ' selected' : '') }}>Ativa</option>
                                        <option value="Recolhida"{{ old('situacao') == 'Recolhida' ? ' selected' : ($viatura->situacao == 'Recolhida' ? ' selected' : '') }}>Recolhida</option>
                                    </select>

                                    @error('situacao')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Kilometragem Inicial</label>
                                    <input type="tel" class="form-control @error('kilometragem') is-invalid @enderror"
                                           name="kilometragem" placeholder="Kilometragem" value="{{ old('kilometragem') ?? $viatura->kilometragem }}">

                                    @error('kilometragem')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-3 offset-md-9">
                                <button class="btn btn-primary mr-2">
                                    <i data-feather="check"></i> Enviar
                                </button>
                                <a class="btn btn-danger" href="{{ route('viatura.index') }}">Voltar</a>
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
    $(function(){
        $(".tagging").select2({
            tags: true,
            maximumSelectionLength: 2
        });
    });
    @if(session()->exists('pos'))
    $(document).ready(function () {
        showNotification('{{ session()->get('text') }}',
            '{{ session()->get('backgroundColor') }}',
            '{{ session()->get('pos') }}',
            '{{ session()->get('actionText') }}',
            '{{ session()->get('actionTextColor') }}',
            '{{ session()->get('duration') }}'
        );
    });
    @endif
</script>
@endsection
