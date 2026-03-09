


<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Header start -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item">User Management</li>
                                <li class="breadcrumb-item active">Roles</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- End start -->
            <div class="row">
                <!-- Form Control starts -->
                <div class="col-md-12">
                    <div class="card">
                        <form id="form">
                            <div class="card-block">
                                <div class="col-sm-12 table-responsive pad0">
                                    <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-xs btn-primary float-right">Add New</a>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Name</th>
                                            <th width="280px">Action</th>
                                        </tr>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($role->name); ?></td>
                                                <td>
                                                    <a class="btn btn-info btn-xs" href="<?php echo e(route('roles.show',$role->id)); ?>"><i class="fa fa-eye"></i> </a>
                                                    
                                                        <a class="btn btn-primary btn-xs" href="<?php echo e(route('roles.edit',$role->id)); ?>"><i class="fa fa-edit"></i> </a>
                                                    
                                                    
                                                        <a class="btn btn-danger btn-xs" href="<?php echo e(route('roles.edit',$role->id)); ?>"><i class="fa fa-trash"></i> </a>
                                                    
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>

                                </div>
                            </div>
                            <!--card-block-->
                        </form>
                    </div>
                    <!--card-->
                </div>
                <!-- Form Control ends -->
            </div>
        </div>
    </div>
    
    
    
    
    
    
    
    
    
    
    <script src="<?php echo e(URL::asset('plugins/jquery/jquery.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/Roles/index.blade.php ENDPATH**/ ?>