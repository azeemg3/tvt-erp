

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
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item">Umrah</li>
                            <li class="breadcrumb-item">Customize Package</li>
                            <li class="breadcrumb-item active">Create New</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="fa fa-exclamation"></i> <?php echo e($error); ?>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if(session('success')): ?>
                                <div class="alert alert-success">
                                    <i class="fa fa-check"></i> <?php echo e(session('success')); ?></div>
                            <?php endif; ?>
                            <form action="<?php echo e(route('customize_packages.store')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Package Name*</label>
                                            <input name="pkg_name" type="text" class="form-control form-control-sm" placeholder="Enter Destination..." value="<?php echo e(old('pkg_name')); ?>">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input name="price" type="text" class="form-control form-control-sm" placeholder="Enter Price" value="<?php echo e(old('price')); ?>">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Makkah Hotel</label>
                                            <input name="makkah_hotel" type="text" class="form-control form-control-sm" placeholder="Makkah Hotel" value="<?php echo e(old('makkah_hotel')); ?>">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Madina Hotel</label>
                                            <input name="madina_hotel" value="<?php echo e(old('madina_hotel')); ?>" type="text" class="form-control form-control-sm" placeholder="Madina Hotel">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Duration</label>
                                            <input name="duraion" value="<?php echo e(old('duraion')); ?>"  type="text" class="form-control form-control-sm" placeholder="Duration e.g total nights">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Makkah Nights</label>
                                            <input name="makkah_night" value="<?php echo e(old('makkah_night')); ?>" type="text" class="form-control form-control-sm" placeholder="Makkah Nights">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Madina Nights</label>
                                            <input name="madina_night" value="<?php echo e(old('madina_night')); ?>"  type="text" class="form-control form-control-sm" placeholder="Madinah Nights">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Traveling Date From</label>
                                            <input type="text" name="traveling_df" value="<?php echo e(old('traveling_df')); ?>" class="form-control form-control-sm date" placeholder="Traveling Date From">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Traveling Date To</label>
                                            <input type="text" name="traveling_dt" value="<?php echo e(old('traveling_dt')); ?>" class="form-control form-control-sm date" placeholder="Traveling Date From">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Package Images</label>
                                            <input type="file" multiple name="pkg_images[]" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Upload Brochure Images</label>
                                            <input type="file" name="brochure_image" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Package Details</label>
                                            <textarea name="pkg_details" class="textarea" placeholder="Place some text here"
                                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo e(old('makkah_hotel')); ?></textarea>

                                        </div>
                                    </div>
                                    <!--col-->
                                </div>
                                <!--end-row-->
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-sm btn-success btn-flat float-right">Submit</button>
                                    </div>
                                </div>
                                <!--end-row-->
                            </form>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
<?php $__env->stopSection(); ?><!-- jQuery -->
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/cms/umrah/customize/create.blade.php ENDPATH**/ ?>