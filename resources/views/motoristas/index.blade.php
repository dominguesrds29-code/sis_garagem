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
                                <h4 class="d-inline-block">Lista de Motoristas</h4>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3">
                                <a href="{{ route('motorista.create') }}"
                                   class="btn btn-outline-primary btn-rounded btn-lg float-right">Cadastrar Motorista</a>
                            </div>
                        </div>
                        <div class="table-responsive mb-4">
                            <table id="data-table" class="table style-3  table-hover data-table">
                                <thead>
                                <tr>
                                    <th class="checkbox-column text-center"> ID</th>
                                    <th>Nome</th>
                                    <th class="text-center">CNH</th>
                                    <th class="text-center">Categoria</th>
                                    <th class="text-center">Validade CNH</th>
                                    <th class="text-center">Validade Autorização</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($motoristas as $motorista)
                                    <tr id="{{ $motorista->id }}">
                                        <td class="checkbox-column text-center"> {{ $motorista->id }}</td>
                                        <td>{{ $motorista->user->name }}</td>
                                        <td class="text-center">{{ $motorista->cnh_number }}</td>
                                        <td class="text-center">{{ $motorista->cnh_category }}</td>
                                        <td class="text-center">{{ $motorista->cnh_validate }}</td>
                                        <td class="text-center">{{ $motorista->authorization_date }}</td>
                                        <td class="text-center">
                                            <ul class="table-controls">
                                                <li class="m-2">
                                                    <a href="{{ route('motorista.edit', $motorista->id) }}"
                                                       class="bs-tooltip"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title="" data-original-title="Editar">
                                                        <i data-feather="edit-2" class="p-1 br-6 mb-1"></i>
                                                    </a></li>

                                                <li class="m-2">
                                                    <a href="javascript:void(0);" class="bs-tooltip desactive-motorista"
                                                       data-action="{{ route('motorista.desactivate', $motorista->id) }}"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="Desativar Autorização">
                                                        <i data-feather="x-octagon" class="p-1 br-6 mb-1"></i>
                                                    </a></li>

                                                <li class="m-2">
                                                    <a href="javascript:void(0);" class="bs-tooltip del-motorista"
                                                       data-action="{{ route('motorista.destroy', $motorista->id) }}"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="Excluir Autorização">
                                                        <i data-feather="trash-2" class="p-1 br-6 mb-1"></i>
                                                    </a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
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

            $(document).on('click', '.desactive-motorista', function () {
                const route = $(this).data('action');
                showConfirm('Desativar Autorização', 'Deseja realmente desativar esta Autorização?', 'question', 'Confirmar', 'Cancelar', route, 'PUT');
            });

            $(document).on('click', '.del-motorista', function () {
                const route = $(this).data('action');
                showConfirm('Excluir Autorização', 'Deseja realmente excluir esta Autorização?', 'question', 'Confirmar', 'Cancelar', route, 'DELETE');
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
