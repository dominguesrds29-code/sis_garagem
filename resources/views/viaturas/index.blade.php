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
                                <h4 class="d-inline-block">Lista de Viaturas</h4>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3">
                                <a href="{{ route('viatura.create') }}"
                                   class="btn btn-outline-primary btn-rounded btn-lg float-right">Nova Viatura</a>
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
                                                    <a href="{{ route('viatura.edit', $viatura->id) }}"
                                                       class="bs-tooltip"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title="" data-original-title="Editar">
                                                        <i data-feather="edit-2" class="p-1 br-6 mb-1"></i>
                                                    </a></li>

                                                <li class="m-2">
                                                    <a href="javascript:void(0);" class="bs-tooltip desactive-viatura"
                                                       data-action="{{ route('viatura.desactivate', $viatura->id) }}"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="Desativar Viatura">
                                                        <i data-feather="x-octagon" class="p-1 br-6 mb-1"></i>
                                                    </a></li>

                                                <li class="m-2">
                                                    <a href="javascript:void(0);" class="bs-tooltip del-viatura"
                                                       data-action="{{ route('viatura.destroy', $viatura->id) }}"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="Excluir Viatura">
                                                        <i data-feather="trash-2" class="p-1 br-6 mb-1"></i>
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

            $(document).on('click', '.desactive-viatura', function () {
                const route = $(this).data('action');
                showConfirm('Desativação de Viatura', 'Deseja realmente desativar esta Viatura?', 'question', 'Confirmar', 'Cancelar', route, 'PUT');
            });

            $(document).on('click', '.del-viatura', function () {
                const route = $(this).data('action');
                showConfirm('Excluir Viatura', 'Deseja realmente excluir esta Viatura?', 'question', 'Confirmar', 'Cancelar', route, 'DELETE');
            })
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
        @if(session()->exists('title'))
        showMessage('{{ session()->get('title') }}',
            '{{ session()->get('text') }}',
            '{{ session()->get('type') }}'
        );
        @endif
    </script>
@endsection
