
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Ziarat Rate</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Application Setup</li>
                            <li class="breadcrumb-item">Rate Setup</li>
                            <li class="breadcrumb-item active">Ziarat Rate List</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>From City</th>
                                    <th>Ziarat City</th>
                                    <th>Contact Name</th>
                                    <th>Contact Number</th>
                                    <th>From Date</th>
                                    <th>Till Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        
                        
                        
                        
                        
                        
                        
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php echo $__env->make('Rate_setup.ziarat_rate.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <script>
        function add_new() {
            $("#new").modal();
        }
        function more_item() {
            $(".more-item").append('<div class="row">' +
            '                <div class="form-group col-md-2">' +
                '                <select name="" class="form-control form-control-sm">' +
                '                <option value="">Select</option>' +
                '                </select>' +
                '                </div>' +
            '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Curr Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <button type="button" class="btn btn-xs btn-danger" onclick="more_item()"><i class="fa fa-trash"></i> </button>' +
                '                </div>' +
                '                </div>');
        }
    </script>
<?php $__env->stopSection(); ?><!-- jQuery -->
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/Rate_setup/ziarat_rate/index.blade.php ENDPATH**/ ?>