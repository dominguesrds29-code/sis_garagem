@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-lg-12">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <div class="row mb-3">
                            <div class="col-xl-9 col-md-9 col-sm-9 col-9">
                                <h4 class="d-inline-block">Gráfico de Histórico de Saídas (Por Mês)</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="saidasChart"></div>
                            </div>
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
            var options = {
                series: [{
                    name: 'Número de Saídas',
                    data: {!! json_encode($totais) !!}
                }],
                chart: {
                    type: 'bar',
                    height: 400
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                        columnWidth: '45%'
                    }
                },
                colors: ['#009688'],
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: {!! json_encode($datas) !!},
                    labels: {
                        style: {
                            fontSize: '13px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Quantidade Total de Saídas'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#saidasChart"), options);
            chart.render();
        });
    </script>
@endsection
