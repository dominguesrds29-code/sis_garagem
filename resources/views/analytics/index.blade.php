@extends('layouts.app')

@section('css')
    <link href="{{asset('plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .widget-content-area {
            border-radius: 6px;
            margin-bottom: 30px;
        }
        .widget-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #3b3f5c;
        }
    </style>
@endsection

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <!-- KM por Motorista (Top 10) -->
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h5 class="">Top 10 Motoristas (KM Rodados)</h5>
                    </div>
                    <div class="widget-content">
                        <div id="motoristasChart"></div>
                    </div>
                </div>
            </div>

            <!-- KM Rodados por Dia (Últimos 30 dias) -->
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one">
                    <div class="widget-heading" style="display: flex; justify-content: space-between; align-items: center; width: 100%; gap: 15px;">
                        <h5 class="" style="margin-bottom: 0;">KM Totais por Dia (Últimos 30 dias)</h5>
                        <div style="width: 200px;">
                            <select id="viaturaSelect" class="form-control" style="padding: 4px 10px; height: auto; font-size: 13px; border-radius: 6px;">
                                <option value="all">Todas as Viaturas</option>
                                @foreach($viaturas as $viatura)
                                    <option value="{{ $viatura->id }}">{{ $viatura->modelo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="widget-content">
                        <div id="kmDiaChart"></div>
                    </div>
                </div>
            </div>

            <!-- Uso de Viaturas -->
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h5 class="">Uso de Viaturas (Nº de Saídas)</h5>
                    </div>
                    <div class="widget-content">
                        <div id="viaturasChart"></div>
                    </div>
                </div>
            </div>

            <!-- Histórico de Saídas (Por Mês) -->
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h5 class="">Histórico de Saídas (Por Mês)</h5>
                    </div>
                    <div class="widget-content">
                        <div id="saidasChart"></div>
                    </div>
                </div>
            </div>

            <!-- Viaturas Mais Rodadas -->
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two">
                    <div class="widget-heading">
                        <h5 class="">Viaturas Mais Rodadas</h5>
                    </div>
                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><div class="th-content">Modelo</div></th>
                                        <th><div class="th-content">Kilometragem</div></th>
                                        <th><div class="th-content">Situação</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($viaturasMaisRodadas as $viatura)
                                    <tr>
                                        <td><div class="td-content">{{ $viatura->modelo }}</div></td>
                                        <td><div class="td-content"><span class="badge badge-info">{{ number_format($viatura->kilometragem, 0, ',', '.') }} KM</span></div></td>
                                        <td><div class="td-content"><span class="badge {{ $viatura->situacao == 'Ativa' ? 'badge-success' : 'badge-danger' }}">{{ $viatura->situacao }}</span></div></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Viaturas Mais Antigas (Cadastro) -->
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two">
                    <div class="widget-heading">
                        <h5 class="">Viaturas Mais Antigas (Cadastro)</h5>
                    </div>
                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><div class="th-content">Modelo</div></th>
                                        <th><div class="th-content">Data Cadastro</div></th>
                                        <th><div class="th-content">Tempo no Sistema</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($viaturasMaisAntigas as $viatura)
                                    <tr>
                                        <td><div class="td-content">{{ $viatura->modelo }}</div></td>
                                        <td><div class="td-content">{{ $viatura->created_at->format('d/m/Y') }}</div></td>
                                        <td><div class="td-content">{{ $viatura->created_at->diffForHumans() }}</div></td>
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
    <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>
    <script>
        // Dados para o gráfico de motoristas
        var motoristasNames = @json($motoristasKms->map(fn($m) => $m->motorista->user_war_name ?? 'N/A'));
        var motoristasValues = @json($motoristasKms->pluck('total_km'));

        var optionsMotoristas = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                }
            },
            dataLabels: { enabled: false },
            series: [{
                name: 'KM Rodados',
                data: motoristasValues
            }],
            xaxis: {
                categories: motoristasNames,
            },
            colors: ['#4361ee'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " KM"
                    }
                }
            }
        }
        var chartMotoristas = new ApexCharts(document.querySelector("#motoristasChart"), optionsMotoristas);
        chartMotoristas.render();

        // Dados para o gráfico de KM por dia
        var diasLabels = @json($kmPorDia->pluck('data'));
        var diasValues = @json($kmPorDia->pluck('total_km'));

        var optionsKmDia = {
            chart: {
                type: 'area',
                height: 350,
                toolbar: { show: false }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            series: [{
                name: 'Total KM',
                data: diasValues
            }],
            xaxis: {
                type: 'datetime',
                categories: diasLabels,
            },
            colors: ['#00ab55'],
            tooltip: {
                x: { format: 'dd/MM/yy' },
                y: {
                    formatter: function (val) {
                        return val + " KM"
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                }
            },
        }
        var chartKmDia = new ApexCharts(document.querySelector("#kmDiaChart"), optionsKmDia);
        chartKmDia.render();

        // Filtro dinâmico do gráfico de KM rodados por dia
        $('#viaturaSelect').on('change', function () {
            var viaturaId = $(this).val();
            var url = '{{ route("estatisticas.km_por_dia", ["viatura_id" => ":id"]) }}';
            url = url.replace(':id', viaturaId);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    chartKmDia.updateOptions({
                        xaxis: {
                            categories: data.labels
                        }
                    });
                    chartKmDia.updateSeries([{
                        name: 'Total KM',
                        data: data.values
                    }]);
                },
                error: function (xhr, status, error) {
                    console.error("Erro ao carregar dados do gráfico: ", error);
                }
            });
        });

        // Gráfico de Uso de Viaturas
        var viaturasModelos = @json($usoViaturasModelos);
        var viaturasTotais = @json($usoViaturasTotais);

        var optionsViaturas = {
            series: [{
                name: 'Número de Saídas',
                data: viaturasTotais
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '45%'
                }
            },
            colors: ['#4361ee'],
            dataLabels: {
                enabled: true
            },
            xaxis: {
                categories: viaturasModelos,
                labels: {
                    style: {
                        fontSize: '13px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Quantidade de Vezes Utilizada'
                }
            }
        };

        var chartViaturas = new ApexCharts(document.querySelector("#viaturasChart"), optionsViaturas);
        chartViaturas.render();

        // Gráfico de Histórico de Saídas por Mês
        var saidasMesDatas = @json($saidasMesDatas);
        var saidasMesTotais = @json($saidasMesTotais);

        var optionsSaidas = {
            series: [{
                name: 'Número de Saídas',
                data: saidasMesTotais
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
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
                categories: saidasMesDatas,
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

        var chartSaidas = new ApexCharts(document.querySelector("#saidasChart"), optionsSaidas);
        chartSaidas.render();
    </script>
@endsection
