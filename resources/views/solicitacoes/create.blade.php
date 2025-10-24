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
                    <form name="solicViatura" method='post' action="{{ route('solicitacao.store') }}">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="solicitante" value="{{ auth()->user()->pst_specialty }} {{ auth()->user()->name }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->integration_id }}">
                        <div class="form-row mb-2">
                            <div class="form-group col-md-3">
                                <label>Data de Início:</label>
                                <input id="dtInicio" value="{{ old('dt_inicio')  }}" name="dt_inicio"
                                       class="form-control flatpickr flatpickr-input @error('dt_inicio') is-invalid @enderror"
                                       type="text" placeholder="Selecione uma Data..">

                                @error('dt_inicio')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Hora de Início:</label>
                                <input id="horaInicio" value="{{ old('hora_inicio') }}" name="hora_inicio"
                                       class="form-control flatpickr flatpickr-input @error('hora_inicio') is-invalid @enderror"
                                       type="text" placeholder="Selecione uma Data..">

                                @error('hora_inicio')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Data de Término:</label>
                                <input id="dtFinal" value="{{ old('dt_final') }}" name="dt_final"
                                       class="form-control flatpickr flatpickr-input @error('dt_final') is-invalid @enderror"
                                       type="text" placeholder="Selecione uma Data..">

                                @error('dt_final')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Hora de Término:</label>
                                <input id="horaFinal" value="{{ old('hora_final') }}" name="hora_final"
                                       class="form-control flatpickr flatpickr-input @error('hora_final') is-invalid @enderror"
                                       type="text" placeholder="Selecione uma Data..">

                                @error('hora_final')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Viatura</label>
                                <select class="form-control select2 @error('viatura_id') is-invalid @enderror" name="viatura_id">
                                    @forelse($viaturas as $viatura)
                                        <option value="{{ $viatura->id }}"{{ old('viatura_id') == $viatura->id ? ' selected' : '' }}>{{ $viatura->modelo }}</option>
                                    @empty
                                    @endforelse
                                </select>

                                @error('viatura_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nome do Motorista</label>
                                <select class="form-control select2 @error('motorista_id') is-invalid @enderror" name="motorista_id">
                                    <option value="">Selecione uma opção</option>
                                    @forelse($drivers as $driver)
                                        <option value="{{ $driver->id }}{{ old('motorista_id') == $driver->id ? ' selected' : '' }}">{{ $driver->user_war_name }}</option>
                                    @empty
                                    @endforelse
                                </select>

                                @error('motorista_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Destino</label>
                                <textarea style="resize: none;" rows="3" name="destino" class="form-control @error('destino') is-invalid @enderror">{!! old('destino') !!}</textarea>

                                @error('destino')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Itinerário</label>
                                <textarea style="resize: none;" rows="3" name="itinerario" class="form-control @error('itinerario') is-invalid @enderror">{!! old('itinerario') !!}</textarea>

                                @error('itinerario')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Missão</label>
                                <textarea style="resize: none;" rows="3" name="missao" class="form-control @error('missao') is-invalid @enderror">{!! old('missao') !!}</textarea>

                                @error('missao')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Passageiros</label>
                                <textarea style="resize: none;" rows="3" name="passageiros" class="form-control @error('passageiros') is-invalid @enderror">{!! old('passageiros') !!}</textarea>

                                @error('passageiros')
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
                            <a class="btn btn-danger" href="{{ route('solicitacao.index') }}">Sair</a>
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
            $(".select2").select2({
                language: {
                    noResults: function() {
                        return "Nada Encontrado!";
                    }
                }
            });
            $(".tagging").select2({
                multiple: true,
                language: {
                    noResults: function() {
                        return "Nada Encontrado!";
                    }
                }
            });
            var f1 = flatpickr(document.getElementById('dtInicio'), {
                altInput: true,
                altFormat: "d/m/Y",
                dateFormat: "Y-m-d",
                locale: "pt",
                minDate: "today",
            });
            var f2 = flatpickr(document.getElementById('dtFinal'), {
                altInput: true,
                altFormat: "d/m/Y",
                dateFormat: "Y-m-d",
                locale: "pt",
                minDate: "today",
            });
            var f3 = flatpickr(document.getElementById('horaInicio'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "08:00"
            });
            var f4 = flatpickr(document.getElementById('horaFinal'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "17:00"
            });
        });
    </script>
@endsection
