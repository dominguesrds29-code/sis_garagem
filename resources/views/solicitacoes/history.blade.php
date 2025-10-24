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
                                <h4 class="d-inline-block">Histórico de Solicitações</h4>
                            </div>
                        </div>
                        <div class="table-responsive mb-4">
                            <table id="data-table" class="table style-3  table-hover">
                                <thead>
                                <tr>
                                    @foreach ($heads as $head)
                                        <th class="text-center">{{ $head['label'] }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    @foreach ($heads as $head)
                                        <th class="text-center">{{ $head['label'] }}</th>
                                    @endforeach
                                </tr>
                                </tfoot>
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
