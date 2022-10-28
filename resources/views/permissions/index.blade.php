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
                                <h4 class="d-inline-block">Listagem de Permissões</h4>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3">
                                <a href="{{ route('permission.create') }}"
                                   class="btn btn-outline-primary btn-rounded btn-lg float-right">Nova Permissão</a>
                            </div>
                        </div>
                        <div class="table-responsive mb-4">
                            <table id="data-table" class="table style-3 table-hover">
                                <thead>
                                <tr>
                                    <th class="checkbox-column text-center"> ID</th>
                                    <th>Permissão</th>
                                    <th class="text-center">Guard</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </thead>
                                <tbody style="text-align: center;">

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

            $(document).on('click', '.del-item', function () {
                const route = $(this).data('action');
                showConfirm('Excluir Permissão', 'Deseja realmente excluir esta Permissão?', 'question', 'Confirmar', 'Cancelar', route, 'DELETE');
            })

            $('#data-table').DataTable(
                {!! json_encode($config) !!}
            );
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
            '{!!  session()->get('text') !!}',
            '{{ session()->get('type') }}'
        );
        @endif
    </script>
@endsection
