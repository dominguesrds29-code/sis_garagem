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
                            <table id="data-table" class="table style-3 table-hover">
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

            $(document).on('click', '.active-item', function () {
                const route = $(this).data('action');
                showConfirm('Reativação de Viatura', 'Deseja realmente reativar esta Viatura?', 'question', 'Confirmar', 'Cancelar', route, 'PUT');
            });

            $('#data-table').DataTable(
                {!! json_encode($config) !!}
            );
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
