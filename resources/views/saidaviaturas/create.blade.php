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
                        <h4>Registro de Saída de Viatura</h4>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form name="cadSaidaViatura" method='post' action="{{ route('saidaviatura.store') }}">
                            @csrf
                            @method('POST')
                            <div class="form-row mb-2">
                                <div class="form-group col-md-6">
                                    <label>Viatura</label>
                                    <select class="placeholder select2 setViatura form-control @error('viatura_id') is-invalid @enderror" name="viatura_id">
                                        <option value="">Selecione uma opção...</option>
                                        @foreach($viaturas as $viatura)
                                            <option value="{{ $viatura->id }}" {{ old('viatura_id') == $viatura->id ? ' selected' : (isset($getinId) && $getinId == $viatura->id ? 'selected' : '') }}>
                                                {{ $viatura->modelo }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('viatura_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Motorista</label>
                                    <select class="placeholder select2 form-control @error('motorista_id') is-invalid @enderror" name="motorista_id">
                                        <option value="">Selecione uma opção...</option>
                                        @foreach($motoristas as $motorista)
                                            <option value="{{ $motorista->id }}" {{ old('motorista_id') == $motorista->id ? ' selected' : '' }}>
                                                {{ $motorista->user_war_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('motorista_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Ocupantes</label>
                                    <textarea style="resize: none;" rows="3" name="ocupantes" class="form-control @error('ocupantes') is-invalid @enderror">{!! old('ocupantes') !!}</textarea>

                                    @error('ocupantes')
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
                                    <label>Missão</label>
                                    <textarea style="resize: none;" rows="3" name="missao" class="form-control @error('missao') is-invalid @enderror">{!! old('missao') !!}</textarea>

                                    @error('missao')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Hodômetro de Saída:</label>
                                    <input id="hodometro_saida" value="{{ old('hodometro_saida') ?? $hodometro_saida  }}" name="hodometro_saida"
                                        class="form-control @error('hodometro_saida') is-invalid @enderror"
                                        type="text">

                                    @error('hodometro_saida')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Hora de Início:</label>
                                    <input id="hora_saida" value="{{ old('hora_saida') }}" name="hora_saida"
                                        class="form-control flatpickr flatpickr-input @error('hora_saida') is-invalid @enderror"
                                        type="text" placeholder="Selecione um Horário..">

                                    @error('hora_saida')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-4 offset-md-8">
                                <button class="btn btn-primary mr-2" name="only-save" value="true">
                                    <i data-feather="check"></i> Cadastrar
                                </button>
                                <button class="btn btn-success mr-2">
                                    <i data-feather="check"></i> Cadastrar e Criar Novo
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.setViatura').change(function(){
                const viaturaId = $(this).val();
                const route = "{{ route('viatura.getKilometragem', ':id') }}".replace(':id', viaturaId);
                if(viaturaId){
                    $.get(route, function(data){
                        if(data.kilometragem){
                            $('#hodometro_saida').val(data.kilometragem);
                        } else {
                            $('#hodometro_saida').val('');
                        }
                    }, 'json');
                } else {
                    $('#hodometro_saida').val('');
                }
            });

            $(".select2").select2({
                language: {
                    noResults: function() {
                        return "Nada Encontrado!";
                    }
                }
            });

            var f1 = flatpickr(document.getElementById('hora_saida'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "08:00"
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
