
<?php $__env->startSection('content'); ?>
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
						<h1 class="m-0 text-dark"><?php echo e(__('main.dashboard')); ?></h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
        <?php if(Auth::user()->getRoleNames()[0]=='Admin'): ?>
		<section class="content home-main">
			<div class="container-fluid">
				<!-- Small boxes (Stat box) -->
				<div class="row">
					<div class="col-lg-2 col-6">
						<!-- small box -->
						<div class="small-box bg-info">
							<div class="inner">
								<h3>150</h3>

								<p>Total Agents</p>
							</div>
							<div class="icon">
								<i class="ion ion-bag"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-2 col-6">
						<!-- small box -->
						<div class="small-box bg-success">
							<div class="inner">
								<h3>53<sup style="font-size: 20px">%</sup></h3>

								<p>Total Pax</p>
							</div>
							<div class="icon">
								<i class="ion ion-stats-bars"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-2 col-6">
						<!-- small box -->
						<div class="small-box bg-warning">
							<div class="inner">
								<h3>44</h3>

								<p>Total UB</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-2 col-6">
						<!-- small box -->
						<div class="small-box bg-dark">
							<div class="inner">
								<h3>65</h3>

								<p>Total Groups</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-2 col-6">
						<!-- small box -->
						<div class="small-box bg-blue">
							<div class="inner">
								<h3>65</h3>

								<p>Total Mofa</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-2 col-6">
						<!-- small box -->
						<div class="small-box bg-gradient-maroon">
							<div class="inner">
								<h3>65</h3>

								<p>Total Visa</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
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
					<section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card">
							<div class="card-header bg-info">
								<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Quarantine Bookings
								</h3>
							</div><!-- /.card-header -->
							<div class="card-body">
                                <table class="table table-condensed">
                                    <thead>
                                    <tr>
                                        <th><small>Package Name</small></th>
                                        <th class="text-blue"><small>Total Booking</small></th>
                                        <th class="text-yellow"><small>Pending Booking</small></th>
                                        <th class="text-success"><small>Approved Booking</small></th>
                                        <th class="text-danger"><small>Cancel Booking</small></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Economy | 3 Days | JEDDAH</td>
                                        <td>10</td>
                                        <td>05</td>
                                        <td>04</td>
                                        <td>01</td>
                                    </tr>
                                    <tr>
                                        <td>Economy | 3 Days | JEDDAH</td>
                                        <td>10</td>
                                        <td>05</td>
                                        <td>04</td>
                                        <td>01</td>
                                    </tr>
                                    </tbody>
                                </table>
							</div><!-- /.card-body -->
						</div>
						<!-- /.card -->
					</section>
					<!-- /.Left col -->
                    <!-- Left col -->
                    <section class="col-lg-6 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header bg-yellow">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Umrah Bookings
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-condensed">
                                    <thead>
                                    <tr>
                                        <th><small>Package Name</small></th>
                                        <th class="text-blue"><small>Total Booking</small></th>
                                        <th class="text-yellow"><small>Pending Booking</small></th>
                                        <th class="text-success"><small>Approved Booking</small></th>
                                        <th class="text-danger"><small>Cancel Booking</small></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Economy | 3 Days | JEDDAH</td>
                                        <td>10</td>
                                        <td>05</td>
                                        <td>04</td>
                                        <td>01</td>
                                    </tr>
                                    <tr>
                                        <td>Economy | 3 Days | JEDDAH</td>
                                        <td>10</td>
                                        <td>05</td>
                                        <td>04</td>
                                        <td>01</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
					<!-- Left col -->
					<section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card">
							<div class="card-header bg-info">
								<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Categories Wise Sale
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
							<div class="card-header bg-info">
								<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Categories Wise Sale
								</h3>
							</div><!-- /.card-header -->
							<div class="card-body">

									<div id="pie-container"></div>

							</div><!-- /.card-body -->
						</div>
						<!-- /.card -->
					</section>
					<!-- /.Left col -->
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card">
							<div class="card-body">

									<div id="container1"></div>
									<div id="container2"></div>
									<div id="container3"></div>

							</div><!-- /.card-body -->
						</div>
						<!-- /.card -->
					</section>
					<!-- /.Left col -->
				</div>
				<!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
        <?php endif; ?>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/bullet.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	<script>
        Highcharts.chart('container', {
            chart: {
                type: 'area'
            },
            title: {
                text: ''
            },
//            subtitle: {
//                text: 'Source: Wikipedia.org'
//            },
            xAxis: {
                categories: ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July'],
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: ''
                },
                labels: {
                    categories: ['1750', '1800', '1850', '1900', '1950', '1999', '2050'],
                }
            },
            tooltip: {
                split: true,
                valueSuffix: ' millions'
            },
            plotOptions: {
                area: {
                    stacking: 'normal',
                    lineColor: '#666666',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#666666'
                    }
                }
            },
            series: [{
                name: 'Tickets',
                data: [502, 635, 809, 947, 1402, 3634, 5268]
            }, {
                name: 'UB',
                data: [106, 107, 111, 133, 221, 767, 1766]
            }, {
                name: 'Visa',
                data: [163, 203, 276, 408, 547, 729, 628]
            }, {
                name: 'Hotel',
                data: [18, 31, 54, 156, 339, 818, 1201]
            }, {
                name: 'Transport',
                data: [2, 2, 2, 6, 13, 30, 46]
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
                    name: 'Tickets',
                    y: 61.41,
                    sliced: true,
                    selected: true
                }, {
                    name: 'UB',
                    y: 11.84
                }, {
                    name: 'Visa',
                    y: 10.85
                }, {
                    name: 'Hotel',
                    y: 4.67
                }, {
                    name: 'Tranport',
                    y: 4.18
                }]
            }]
        });
        //income profit, sale
        Highcharts.setOptions({
            chart: {
                inverted: true,
                marginLeft: 135,
                type: 'bullet'
            },
            title: {
                text: null
            },
            legend: {
                enabled: false
            },
            yAxis: {
                gridLineWidth: 0
            },
            plotOptions: {
                series: {
                    pointPadding: 0.25,
                    borderWidth: 0,
                    color: '#000',
                    targetOptions: {
                        width: '200%'
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            }
        });

        Highcharts.chart('container1', {
            chart: {
                marginTop: 40
            },
            title: {
                text: 'Total Sale, Profit, Expense'
            },
            xAxis: {
                categories: ['<span class="hc-cat-title">Sale</span>']
            },
            yAxis: {
                plotBands: [{
                    from: 0,
                    to: 150,
                    color: '#666'
                }, {
                    from: 150,
                    to: 225,
                    color: '#999'
                }, {
                    from: 225,
                    to: 9e9,
                    color: '#bbb'
                }],
                title: null
            },
            series: [{
                data: [{
                    y: 275,
                    target: 250
                }]
            }],
            tooltip: {
                pointFormat: '<b>{point.y}</b> (with target at {point.target})'
            }
        });

        Highcharts.chart('container2', {
            xAxis: {
                categories: ['<span class="hc-cat-title">Profit</span>']
            },
            yAxis: {
                plotBands: [{
                    from: 0,
                    to: 20,
                    color: '#666'
                }, {
                    from: 20,
                    to: 25,
                    color: '#999'
                }, {
                    from: 25,
                    to: 100,
                    color: '#bbb'
                }],
                labels: {
                    format: '{value}%'
                },
                title: null
            },
            series: [{
                data: [{
                    y: 22,
                    target: 27
                }]
            }],
            tooltip: {
                pointFormat: '<b>{point.y}</b> (with target at {point.target})'
            }
        });


        Highcharts.chart('container3', {
            xAxis: {
                categories: ['<span class="hc-cat-title">Expense</span><br/>']
            },
            yAxis: {
                plotBands: [{
                    from: 0,
                    to: 1400,
                    color: '#666'
                }, {
                    from: 1400,
                    to: 2000,
                    color: '#999'
                }, {
                    from: 2000,
                    to: 9e9,
                    color: '#bbb'
                }],
                labels: {
                    format: '{value}'
                },
                title: null
            },
            series: [{
                data: [{
                    y: 1650,
                    target: 2100
                }]
            }],
            tooltip: {
                pointFormat: '<b>{point.y}</b> (with target at {point.target})'
            },
            credits: {
                enabled: true
            }
        });
        //function lead_notifiation
        function lead_notifcation(recdata) {
            $.ajax({
                url:'http://localhost/uotrips/notify',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:{'message':recdata},
                success:function (data) {

                }
            });
        }
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/home.blade.php ENDPATH**/ ?>