
<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('public/css/lead.css')); ?>">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Statistics</li>
                            <li class="breadcrumb-item active">Statistic</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-info card-tabs">
                                        <div class="card-header p-0 pt-1">
                                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                <?php $__currentLoopData = $province; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="nav-item">
                                                        <a onclick="get_ticket_invoice(1)" class="nav-link <?php if($item->name=='Punjab'): ?> active <?php endif; ?>" id="custom-tabs-one-home-tab" data-toggle="pill" href="#<?php echo e($item->name); ?>" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><i class="fa fa-map-marker"></i> <?php echo e($item->name); ?></a>
                                                    </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <?php $__currentLoopData = $province; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="tab-pane fade show <?php if($item->name=='Punjab'): ?> active <?php endif; ?>" id="<?php echo e($item->name); ?>" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                    <h5><?php echo e($item->name); ?> Statistics</h5>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr class="table-active">
                                                            <th>#</th>
                                                            <th>Division</th>
                                                            <th>Central</th>
                                                            <th>Districts</th>
                                                            <th>Cities</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="get_ticket_inv"></tbody>
                                                    </table>
                                                    <div class="card-footer clearfix">
                                                        <div class="pagination-panel"></div>
                                                    </div>
                                                </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/statistics/index.blade.php ENDPATH**/ ?>