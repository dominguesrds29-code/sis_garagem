@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/flatpickr.css') }}">
@endsection

@section('content')
        <div class="layout-px-spacing">
            {{ $errors }}

            <div class="row layout-spacing layout-top-spacing">
                <div class="col-lg-12">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Editar registro de Saída de Viatura</h4>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form name="editSaidaViatura" method='post' action="{{ route('saidaviatura.storeReturn', $saida_viatura->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $saida_viatura->id }}">
                            <div class="form-row mb-2">
                                <div class="form-group col-md-6">
                                    <label>Viatura</label>
                                    <input type="hidden" name="viatura_id" value="{{ $saida_viatura->viatura_id }}">
                                    <span class="form-control">{{ $saida_viatura->viatura->modelo }}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Motorista</label>
                                    <input type="hidden" name="motorista_id" value="{{ $saida_viatura->motorista_id }}">
                                    <span class="form-control">{{ $saida_viatura->motorista->user_war_name }}</span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Ocupantes</label>
                                    <input type="hidden" name="ocupantes" value="{{ $saida_viatura->ocupantes }}">
                                    <span class="form-control">{{ $saida_viatura->ocupantes }}</span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Destino</label>
                                    <input type="hidden" name="destino" value="{{ $saida_viatura->destino }}">
                                    <span class="form-control">{{ $saida_viatura->destino }}</span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Missão</label>
                                    <input type="hidden" name="missao" value="{{ $saida_viatura->missao }}">
                                    <span class="form-control">{{ $saida_viatura->missao }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Hodômetro de Saída:</label>
                                    <input type="hidden" name="hodometro_saida" value="{{ $saida_viatura->hodometro_saida }}">
                                    <span class="form-control">{{ $saida_viatura->hodometro_saida }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Hora de Saída:</label>
                                    <input type="hidden" name="hora_saida" value="{{ $saida_viatura->hora_saida }}">
                                    <span class="form-control">{{ $saida_viatura->hora_saida }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Hodômetro de Retorno:</label>
                                    <input id="hodometro_retorno" value="{{ old('hodometro_retorno') }}" name="hodometro_retorno"
                                        class="form-control @error('hodometro_retorno') is-invalid @enderror"
                                        type="number" min="0" maxlength="6"
                                        oninput="if(this.value.length > 6) this.value = this.value.slice(0, 6);">

                                    @error('hodometro_retorno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Hora de Retorno:</label>
                                    <input id="hora_retorno" value="{{ old('hora_retorno') }}" name="hora_retorno"
                                        class="form-control flatpickr flatpickr-input @error('hora_retorno') is-invalid @enderror"
                                        type="text" placeholder="Selecione um Horário..">

                                    @error('hora_retorno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-4 offset-md-8">
                                <button class="btn btn-primary mr-2">
                                    <i data-feather="check"></i> Finalizar Retorno
                                </button>
                                <a class="btn btn-danger" href="{{ route('saidaviatura.index') }}">Sair</a>
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
            var f1 = flatpickr(document.getElementById('hora_retorno'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "{{ now()->format('H:i') }}"
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
