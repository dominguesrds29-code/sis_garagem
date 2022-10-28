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
                                <h4 class="d-inline-block">Listagem de Solicitações</h4>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3">
                                <a href="{{ route('solicitacao.create') }}"
                                   class="btn btn-outline-primary btn-rounded btn-lg float-right">Solicitar Viatura</a>
                            </div>
                        </div>
                        <div class="table-responsive mb-4">
                            <table id="data-table" class="table style-3  table-hover">
                                <thead>
                                <tr>
                                    <th class="checkbox-column text-center"> ID</th>
                                    <th>Solicitante</th>
                                    <th class="text-center">Saída</th>
                                    <th class="text-center">Retorno</th>
                                    <th class="text-center">Viatura</th>
                                    <th class="text-center">Motorista</th>
                                    <th class="text-center">Encarregado</th>
                                    <th class="text-center">Chefe</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Solicitado em:</th>
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

            $(document).on('click', '.approve-item', function () {
                const route = $(this).data('action');
                showConfirm('Aprovar Solicitação', 'Deseja realmente aprovar esta Solicitação?', 'question', 'Confirmar', 'Cancelar', route, 'PUT', true);
            });

            $(document).on('click', '.desapprove-item', function () {
                const route = $(this).data('action');
                showConfirm('Reprovar Solicitação', 'Deseja realmente reprovar esta Solicitação?', 'question', 'Confirmar', 'Cancelar', route, 'PUT', true);
            });

            $(document).on('click', '.del-item', function () {
                const route = $(this).data('action');
                showConfirm('Excluir Solicitação', 'Deseja realmente excluir esta Solicitação?', 'question', 'Confirmar', 'Cancelar', route, 'DELETE');
            })

            $(document).on('click', '.archive-item', function () {
                const route = $(this).data('action');
                Swal.fire({
                    title: 'Selecione o status da Missão:',
                    input: 'select',
                    inputOptions: {
                        1: 'Realizada',
                        2: 'Cancelada',
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Arquivar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#1abc9c',
                    cancelButtonColor: '#dd4b39',
                    reverseButtons: true,
                    preConfirm: (opt) => {
                        return $.ajax({
                            url: route,
                            data: {opt: opt},
                            type: 'PUT',
                            dataType: 'JSON',
                        });
                    },
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        if (result.value.error) {
                            Swal.fire(result.value.error.title, result.value.error.text, result.value.error.type);
                        } else {
                            Swal.fire(result.value.message.title, result.value.message.text, result.value.message.type);
                            $('tr[id="' + result.value.id + '"]').fadeOut('slow', function () {
                                $(this).remove();
                            })
                        }
                    }
                });
            });

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
            '{!! session()->get('text')  !!}',
            '{{ session()->get('type') }}'
        );
        @endif
    </script>
@endsection
