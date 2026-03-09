@extends('layouts.app')

@section('content')
    <style>
        #container1 {
            height: 115px;
        }
        #container2, #container3 {
            height: 85px;
        }
        .hc-cat-title {
            font-size: 13px;
            font-weight: bold;
        }

        .highcharts-figure, .highcharts-data-table table {
            min-width: 320px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }
        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }
        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }
        .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
            padding: 0.5em;
        }
        .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }
        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ __('main.accounts_dashboard') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content home-main">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>150000<sup style="font-size: 20px"> Dr</sup></h3>

                                <p>Total Receiveable</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>530000<sup style="font-size: 20px"> cr</sup></h3>

                                <p>Total Payable</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>440000<sup style="font-size: 20px"> cr</sup></h3>

                                <p>Bank & Petty Cash Balance</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Accounts Receiveable
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div id="r-container"></div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                    <!-- Left col -->
                    <section class="col-lg-6 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Accounts Payable
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">

                                <div id="container"></div>

                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                    <!-- Left col -->
                    <section class="col-lg-6 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Bank Accounts
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">

                                <div id="pie-container"></div>

                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{--	<script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>--}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/bullet.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        Highcharts.chart('container', {
            title: {
                text: ''
            },
            xAxis: [{
                categories: ['Tourvision', 'Right Travel', 'Mubashar Travel', 'Nooretaiba', 'Sonya Travel', 'Sonya Travel',
                    'Bukhari Travel', 'Journies', 'Karwane', 'Sonya Travel', 'Sonya Travel', 'Sonya Travel'],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis

            }, { // Secondary yAxis
                labels: {
                    format: '',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
            }],
            series: [{
                name: 'Accounts Payable',
                type: 'spline',
                yAxis: 1,
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],

            }]
        });
        //pie chart
        Highcharts.chart('pie-container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Meezan Bank',
                    y: 6141,
                    sliced: true,
                    selected: true
                }, {
                    name: 'United Bank',
                    y: 1184
                }, {
                    name: 'Bank Alfalah',
                    y: 1085
                }, {
                    name: 'Standard Charted',
                    y: 467
                }, {
                    name: 'MCB',
                    y: 418
                }]
            }]
        });
        //Account Receiveable
        Highcharts.chart('r-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
            },
            series: [{
                name: 'Population',
                data: [
                    ['Azeem', 24200000],
                    ['Naeem', 20800000],
                    ['Hamza', 14900000],
                    ['Waseem', 13700000],
                    ['Nadeem', 13100000],
                    ['Naveed', 1200000],
                    ['Ibrahim', 12000000],
                    ['Saqib', 1220000],
                    ['Hassan', 120000],
                    ['Waleed', 117000],
                    ['Nouman', 1150000],
                    ['Mazhar', 1120000],
                    ['Azhar', 11100000],
                    ['Shamaz', 1060000],
                    ['Waseem', 1060000],
                    ['Haseeb', 106000],
                    ['Haziq', 10300000],
                    ['Haris', 9800000],
                    ['Imtnan', 930000],
                    ['Aitzaz', 930000]
                ],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    </script>

@endsection