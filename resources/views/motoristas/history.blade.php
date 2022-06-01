@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_custom.css')}}">
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-lg-12">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <div class="row mb-3">
                            <div class="col-xl-9 col-md-9 col-sm-9 col-9">
                                <h4 class="d-inline-block">Histórico de Viaturas</h4>
                            </div>
                        </div>
                        <div class="table-responsive mb-4">
                            <table id="data-table" class="table style-3  table-hover data-table">
                                <thead>
                                <tr>
                                    <th class="checkbox-column text-center"> ID</th>
                                    <th>Modelo</th>
                                    <th class="text-center">Combustível</th>
                                    <th class="text-center">Kilometragem</th>
                                    <th class="text-center">Situação</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($viaturas as $viatura)
                                    <tr id="{{ $viatura->id }}">
                                        <td class="checkbox-column text-center"> {{ $viatura->id }}</td>
                                        <td>{{ $viatura->modelo }}</td>
                                        <td class="text-center">{{ $viatura->combustivel }}</td>
                                        <td class="text-center">{{ $viatura->kilometragem }}</td>
                                        <td class="text-center">{{ $viatura->situacao }}</td>
                                        <td class="text-center">
                                            <ul class="table-controls">
                                                <li class="m-2">
                                                    <a href="javascript:void(0);" class="bs-tooltip del-viatura"
                                                       data-action="{{ route('viatura.activate', $viatura->id) }}"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="Reativar Viatura">
                                                        <i data-feather="refresh-cw" class="p-1 br-6 mb-1"></i>
                                                    </a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.del-viatura', function () {
                const route = $(this).data('action');
                showConfirm('Reativação de Viatura', 'Deseja realmente reativar esta Viatura?', 'question', 'Confirmar', 'Cancelar', route, 'PUT');
            })
        });

        @if(session()->exists('pos'))
        $(document).ready(function () {
            showNotification('{{ session()->get('text') }}',
                '{{ session()->get('actionTextColor') }}',
                '{{ session()->get('actionText') }}',
                '{{ session()->get('backgroundColor') }}',
                '{{ session()->get('pos') }}',
                '{{ session()->get('duration') }}'
            );
        });
        @endif
        @if(session()->exists('title'))
        showMessage('{{ session()->get('title') }}',
            '{{ session()->get('text') }}',
            '{{ session()->get('type') }}'
        );
        @endif
    </script>
@endsection
