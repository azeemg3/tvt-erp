

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
                            <li class="breadcrumb-item">Agent Statistic</li>
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
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="dt" class="form-control form-control-sm select2">
                                            <option value="">Pakistan</option>
                                        </select>
                                    </div>
                                </div>
                                <!--col-->
                                <div class="col-md-2">
                                    <select name="dt" class="form-control form-control-sm select2">
                                        <option value="">Punjab</option>
                                    </select>
                                </div>
                                <!--col-->
                                <div class="col-md-2">
                                    <select name="dt" class="form-control form-control-sm select2">
                                        <option value="">City</option>
                                    </select>
                                </div>
                                <!--col-->
                                <div class="col-md-2">
                                    <select name="dt" class="form-control form-control-sm select2">
                                        <option value="">Sub Admin List</option>
                                    </select>
                                </div>
                                <!--col-->
                            </div>
                        </div>
                        <!--card-header-->
                        <div class="card-body">
                            <table id="example2" class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center"><i class="fa fa-map-marker"></i> DHA Phase-1</th>
                                </tr>
                                </thead>
                                <tr>
                                    <th colspan="2"><i class="fa fa-map"></i> Lahore</th>
                                </tr>
                            </table>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Agent</th>
                                    <th>GO</th>
                                    <th>Flight</th>
                                    <th>Hotel</th>
                                    <th>Umrah</th>
                                    <th>Tours</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Test Agent</td>
                                    <td>36</td>
                                    <td>20000000</td>
                                    <td>4</td>
                                    <td>4</td>
                                    <td>4</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>Test Agent</td>
                                    <td>36</td>
                                    <td>20000000</td>
                                    <td>4</td>
                                    <td>4</td>
                                    <td>4</td>
                                    <td>4</td>
                                </tr>
                                </tbody>
                            </table>
                            <table id="example2" class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center"><i class="fa fa-map-marker"></i> Askari-9</th>
                                </tr>
                                </thead>
                                <tr>
                                    <th colspan="2"><i class="fa fa-map"></i> Lahore</th>
                                </tr>
                            </table>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Agent</th>
                                    <th>GO</th>
                                    <th>Flight</th>
                                    <th>Hotel</th>
                                    <th>Umrah</th>
                                    <th>Tours</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Test Agent</td>
                                    <td>36</td>
                                    <td>20000000</td>
                                    <td>4</td>
                                    <td>4</td>
                                    <td>4</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>Test Agent</td>
                                    <td>36</td>
                                    <td>20000000</td>
                                    <td>4</td>
                                    <td>4</td>
                                    <td>4</td>
                                    <td>4</td>
                                </tr>
                                </tbody>
                            </table>
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
    <script>
        $(function () {
            $(".select2").select2();
        });
        get_data();
        function get_data(page){
            $.ajax({
                url:"<?php echo e(url('get_province')); ?>?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].name+'</td>';
                        htmlData+='<td>'+data.data[i].countr.name+'</td>';
                        htmlData+='<td>';
                        htmlData+='<a href="javascript:void(0)" onclick="edit('+data.data[i].id+')"><i class="fa fa-edit"> </a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/statistics/agent/index.blade.php ENDPATH**/ ?>