
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Api Management</li>
                            <li class="breadcrumb-item active">Api Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-suitcase-rolling"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Pending Bookings</span>
                                <span class="info-box-number">04</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-suitcase-rolling"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Approved Bookings</span>
                                <span class="info-box-number">10</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-suitcase-rolling"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Cacelled Bookings</span>
                                <span class="info-box-number">02</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-suitcase-rolling"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">All Bookings</span>
                                <span class="info-box-number">20</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-6">
                        <!-- TABLE: LATEST ORDERS -->
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Recent Bookings</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                        <tr>
                                            <th>#Booking</th>
                                            <th>Email</th>
                                            <th>Booking By</th>
                                            <th>Booking Type</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><a href="#">OR9842</a></td>
                                            <td>Agent</td>
                                            <td>info@uotrips.com</td>
                                            <td>Ticket</td>
                                            <td><span class="badge badge-success">Approved</span></td>
                                            <td>2022-02-10</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">OR9842</a></td>
                                            <td>info@uotrips.com</td>
                                            <td>Agent</td>
                                            <td>Hotel</td>
                                            <td><span class="badge badge-warning">Pending</span></td>
                                            <td>2022-02-10</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">OR9842</a></td>
                                            <td>info@uotrips.com</td>
                                            <td>Guest</td>
                                            <td>Transport</td>
                                            <td><span class="badge badge-danger">Cancelled</span></td>
                                            <td>2022-02-10</td>
                                        </tr><tr>
                                            <td><a href="#">OR9842</a></td>
                                            <td>info@uotrips.com</td>
                                            <td>Guest</td>
                                            <td>Transport</td>
                                            <td><span class="badge badge-danger">Cancelled</span></td>
                                            <td>2022-02-10</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                        
                        
                        
                        
                        <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <!-- Left col -->
                    <div class="col-md-6">
                        <!-- TABLE: LATEST ORDERS -->
                        <div class="card">
                            <div class="card-header bg-gradient-yellow border-transparent">
                                <h3 class="card-title">Api Balance ($2000)</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Recent Transactions</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Payment Status</th>
                                            <th>Descriptions</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>100$</td>
                                            <td><span class="badge badge-success">Succeeded</span></td>
                                            <td>Make Test Payment</td>
                                            <td>2022-02-10</td>
                                        </tr>
                                        <tr>
                                            <td>100$</td>
                                            <td><span class="badge badge-success">Succeeded</span></td>
                                            <td>Make Test Payment</td>
                                            <td>2022-02-10</td>
                                        </tr>
                                        <tr>
                                            <td>50$</td>
                                            <td><span class="badge badge-danger">Failed</span></td>
                                            <td>Make Test Payment</td>
                                            <td>2022-02-10</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                        
                        
                        
                        
                        <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <!-- Left col -->
                </div>
                <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript">
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
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/Api_managements/index.blade.php ENDPATH**/ ?>