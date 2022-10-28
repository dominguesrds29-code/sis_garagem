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
                        <h4>Cadastro de Autorizações de Motoristas</h4>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form name="cadMotorista" method='post' action="{{ route('motorista.store') }}">
                            @csrf
                            @method('POST')
                            <div class="form-row mb-2">
                                <div class="form-group col-md-8">
                                    <label>Nome do Motorista</label>
                                    <select class="placeholder form-control drivers @error('user_war_name') is-invalid @enderror" name="user_war_name">
                                        @forelse($users as $user)
                                            <option value="{{ $user->id }}#{{ $user->war_name }}"{{ old('user_war_name') == ($user->id . '#' . $user->war_name) ? ' selected' : '' }}>{{ $user->war_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>

                                    @error('user_war_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Número da CNH</label>
                                    <input type="tel" class="form-control @error('cnh_number') is-invalid @enderror" name="cnh_number" placeholder="Nº CNH" value="{{ old('cnh_number') }}">

                                    @error('cnh_number')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="form-group col-md-4">
                                    <label>Categoria da CNH</label>
                                    <select class="placeholder tagging form-control @error('cnh_category') is-invalid @enderror" name="cnh_category[]" multiple="multiple">
                                        <option value="A"{{ (old('cnh_category') && in_array('A', old('cnh_category'))) ? ' selected' : '' }}>A</option>
                                        <option value="B"{{ (old('cnh_category') && in_array('B', old('cnh_category'))) ? ' selected' : '' }}>B</option>
                                        <option value="C"{{ (old('cnh_category') && in_array('C', old('cnh_category'))) ? ' selected' : '' }}>C</option>
                                        <option value="D"{{ (old('cnh_category') && in_array('D', old('cnh_category'))) ? ' selected' : '' }}>D</option>
                                        <option value="E"{{ (old('cnh_category') && in_array('E', old('cnh_category'))) ? ' selected' : '' }}>E</option>
                                    </select>

                                    @error('cnh_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Validade da CNH</label>
                                    <input id="cnh_validate" value="{{ old('cnh_validate') }}" name="cnh_validate" class="form-control flatpickr flatpickr-input active @error('cnh_validate') is-invalid @enderror" type="text" placeholder="Selecione uma Data..">

                                    @error('cnh_validate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Validade da Autorização</label>
                                    <input id="authorization_date" value="{{ old('authorization_date') }}" name="authorization_date" class="form-control flatpickr flatpickr-input active @error('authorization_date') is-invalid @enderror" type="text" placeholder="Selecione uma Data..">

                                    @error('authorization_date')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-3 offset-md-9">
                                <button class="btn btn-primary mr-2">
                                    <i data-feather="check"></i> Cadastrar
                                </button>
                                <a class="btn btn-danger" href="{{ route('motorista.index') }}">Sair</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('js')
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/pt.js') }}"></script>
<script>
    $(function(){
        $(".drivers").select2({
            placeholder: "Selecione uma opção...",
            allowClear: true,
            language: {
                noResults: function() {
                    return "Nada Encontrado!";
                }
            }
        });
        $(".tagging").select2({
            placeholder: "Selecione as opções...",
            allowClear: true,
            multiple: true,
            language: {
                noResults: function() {
                    return "Nada Encontrado!";
                }
            }
        });
        var f1 = flatpickr(document.getElementById('cnh_validate'), {
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            locale: "pt",
            minDate: "today",
        });
        var f2 = flatpickr(document.getElementById('authorization_date'), {
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            locale: "pt",
            minDate: "today",
        });
    });
</script>
@endsection
