<?php
/**
 * Created by PhpStorm.
 * User: TOSHIBA
 * Date: 29-Jan-22
 * Time: 6:45 PM
 */
?>

<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Reports</li>
                            <li class="breadcrumb-item">Lead Reports</li>
                            <li class="breadcrumb-item active">Customer Reports</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Customer Reports</h3><br>
                            <form action="<?php echo e(url('reports/lead_reports/customer_report')); ?>" method="post" target="_blank">
                                <?php echo csrf_field(); ?>
                            <div class="row">
                                    <div class="col-md-2 form-group">
                                        <input type="text" name="" class="form-control form-control-sm date" placeholder="Date From">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="text" name="" class="form-control form-control-sm date" placeholder="Date to">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-print"></i> </button>
                                    </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.card-header -->
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
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
<?php $__env->stopSection(); ?><!-- jQuery -->
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/Reports/leadReports/customer/index.blade.php ENDPATH**/ ?>