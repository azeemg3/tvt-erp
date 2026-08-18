@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ __('main.accounts_dashboard') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Accounts</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content home-main">
            <div class="container-fluid">
                <p class="text-muted mb-2">Balances as on {{ date('d-M-Y', strtotime($asOn)) }} from the chart of accounts.</p>
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $receivableBox['amount'] }}
                                    @if($receivableBox['side'])
                                        <sup style="font-size: 20px"> {{ $receivableBox['side'] }}</sup>
                                    @endif
                                </h3>
                                <p>Total Receivable</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ $clientsUrl }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $payableBox['amount'] }}
                                    @if($payableBox['side'])
                                        <sup style="font-size: 20px"> {{ $payableBox['side'] }}</sup>
                                    @endif
                                </h3>
                                <p>Total Payable</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ $vendorsUrl }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $bankBox['amount'] }}
                                    @if($bankBox['side'])
                                        <sup style="font-size: 20px"> {{ $bankBox['side'] }}</sup>
                                    @endif
                                </h3>
                                <p>Bank &amp; Petty Cash Balance</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ $cashBankUrl }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Accounts Receivable
                                </h3>
                            </div>
                            <div class="card-body">
                                @if(count($receivableChart))
                                    <div id="r-container"></div>
                                @else
                                    <p class="text-muted text-center mb-0 py-4">No outstanding receivable balances.</p>
                                @endif
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-6 connectedSortable">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Accounts Payable
                                </h3>
                            </div>
                            <div class="card-body">
                                @if(count($payableChart))
                                    <div id="container"></div>
                                @else
                                    <p class="text-muted text-center mb-0 py-4">No outstanding payable balances.</p>
                                @endif
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-6 connectedSortable">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Bank Accounts
                                </h3>
                            </div>
                            <div class="card-body">
                                @if(count($bankChart))
                                    <div id="pie-container"></div>
                                @else
                                    <p class="text-muted text-center mb-0 py-4">No bank / petty cash balances to display.</p>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        (function () {
            var receivableChart = @json($receivableChart);
            var payableChart = @json($payableChart);
            var bankChart = @json($bankChart);

            if (payableChart.length && document.getElementById('container')) {
                Highcharts.chart('container', {
                    title: { text: '' },
                    xAxis: [{
                        categories: payableChart.map(function (p) { return p.name; }),
                        crosshair: true
                    }],
                    yAxis: [{}, {
                        labels: {
                            format: '',
                            style: { color: Highcharts.getOptions().colors[0] }
                        }
                    }],
                    tooltip: {
                        pointFormat: 'Payable: <b>{point.y:,.2f}</b>'
                    },
                    series: [{
                        name: 'Accounts Payable',
                        type: 'spline',
                        yAxis: 1,
                        data: payableChart.map(function (p) { return p.y; })
                    }]
                });
            }

            if (bankChart.length && document.getElementById('pie-container')) {
                Highcharts.chart('pie-container', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: { text: '' },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y:,.2f}</b> ({point.percentage:.1f}%)'
                    },
                    accessibility: {
                        point: { valueSuffix: '' }
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
                        name: 'Balance',
                        colorByPoint: true,
                        data: bankChart
                    }]
                });
            }

            if (receivableChart.length && document.getElementById('r-container')) {
                Highcharts.chart('r-container', {
                    chart: { type: 'column' },
                    title: { text: '' },
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
                        title: { text: '' }
                    },
                    legend: { enabled: false },
                    tooltip: {
                        pointFormat: 'Receivable: <b>{point.y:,.2f}</b>'
                    },
                    series: [{
                        name: 'Receivable',
                        data: receivableChart.map(function (p) { return [p.name, p.y]; }),
                        dataLabels: {
                            enabled: true,
                            rotation: -90,
                            color: '#FFFFFF',
                            align: 'right',
                            format: '{point.y:,.0f}',
                            y: 10,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    }]
                });
            }
        })();
    </script>
@endpush
