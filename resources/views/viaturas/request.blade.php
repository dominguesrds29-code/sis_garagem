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
                    <h4>Solicitação de Viaturas</h4>
                </div>
                <div class="widget-content widget-content-area">
                    <form name="solicViatura" method='post' action="{{ route('solicitar.viatura') }}">
                        @csrf
                        @method('POST')
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <label>Data de Início:</label>
                                <input id="basicFlatpickr" value="{{ date('Y-m-d') }}" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Selecione uma Data..">

                                @error('kilometragem')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Data de Término:</label>
                                <input id="basicFlatpickr" value="{{ date('Y-m-d') }}" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Selecione uma Data..">

                                @error('kilometragem')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Categoria CNH</label>
                                <select class="placeholder tagging form-control @error('cnh_category') is-invalid @enderror" name="cnh_category[]" multiple="multiple">
                                    <option value="">Selecione uma opção...</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>

                                @error('cnh_category')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Validade CNH</label>
                                <input id="basicFlatpickr" value="2020-09-04" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date..">

                                @error('kilometragem')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row mb-2">
                            <div class="form-group col-md-5">
                                <label>Nome do Motorista</label>
                                <select class="form-control tagging @error('user_id') is-invalid @enderror" name="user_id">
                                    @forelse($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                    @empty
                                    @endforelse
                                </select>

                                @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <label>Número da CNH</label>
                                <input type="tel" class="form-control @error('cnh_number') is-invalid @enderror" name="cnh_number" placeholder="Nº CNH">

                                @error('cnh_number')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Categoria CNH</label>
                                <select class="placeholder tagging form-control @error('cnh_category') is-invalid @enderror" name="cnh_category[]" multiple="multiple">
                                    <option value="">Selecione uma opção...</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>

                                @error('cnh_category')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Validade CNH</label>
                                <input id="basicFlatpickr" value="2020-09-04" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date..">

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
    <script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('plugins/flatpickr/pt.js') }}"></script>
    <script>
        $(function(){
            $(".tagging").select2({
                tags: true
            });
            var f1 = flatpickr(document.getElementById('basicFlatpickr'), {
                dateFormat: "d/m/Y",
                locale: "pt",
            });
        });
    </script>
@endsection
