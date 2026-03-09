

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
                            <li class="breadcrumb-item">Statistics</li>
                            <li class="breadcrumb-item">Admin Statistic</li>
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
                        <div class="card-body">
                            <table id="example2" class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="2" class="text-center"><i class="fa fa-flag"></i> Pakistan</th>
                                </tr>
                                <tr>
                                    <th class="text-center"><i class="fa fa-users"></i> <?php echo e(Auth::user()->name); ?></th>
                                </tr>
                                </thead>
                            </table>
                            <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="bg-info" colspan="12"><i class="fa fa-map"></i> <?php echo e($province->name); ?></th>
                                    </tr>
                                    <tr>
                                        <th><i class="fa fa-map-marker"></i> City</th>
                                        <th>Sub Admin</th>
                                        <th>Agent</th>
                                        <th>GO</th>
                                        <th>Population</th>
                                        <th>Flight</th>
                                        <th>Hotel</th>
                                        <th>Umrah</th>
                                        <th>Tours</th>
                                        <th>Total</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($city->PID==$province->id): ?>
                                            <tr>
                                                <th><i class="fa fa-map-marker"></i> <?php echo e($city->name); ?></th>
                                                <td>JAM TRAVEL & TOURS</td>
                                                <td>12</td>
                                                <td>36</td>
                                                <td>20000000</td>
                                                <td>4</td>
                                                <td>4</td>
                                                <td>4</td>
                                                <td>4</td>
                                                <td>20</td>
                                                <td>0.001%</td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="pagination-panel"></div>
                        </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/statistics/admin/index.blade.php ENDPATH**/ ?>