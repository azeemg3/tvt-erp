

<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                            <li class="breadcrumb-item">Booking Confirmation</li>
                            <li class="breadcrumb-item active">Transport Confirmation</li>
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
                            <h3 class="card-title">Transport Confirmation List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-xs btn-primary float-right exportToExcel"><i class="fa fa-file-excel"> Export</i> </button>
                            <form id="search-form">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" placeholder="#Booking">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm date" autocomplete="off" placeholder="From Date" name="df">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm date" autocomplete="off" placeholder="To Date" name="dt">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" onclick="get_data(1)" class="btn btn-xs btn-info"><i class="fa fa-search"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#Booking</th>
                                    <th>Guest Name</th>
                                    <th>Pax</th>
                                    <th>Date</th>
                                    <th>From City</th>
                                    <th>To City</th>
                                    <th>Type</th>
                                    <th>Vehicle</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                    <th>Remarks</th>
                                    <th>Acknowledge By</th>
                                    <th width="10%" class="noExl">Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data"></tbody>
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
    <?php echo $__env->make('booking_confirmation.transport_confirmation.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo e(URL::asset('public/export_excel/jquery.table2excel.js')); ?>"></script>
    <script>
        function add_rate(id, total_pax, total_veh, transport_type, source) {
            $("#new").modal();
            $("#form input[name~='total_pax']").val(total_pax);
            $("#form input[name~='UID']").val(id);
            $("#form input[name~='total_vehicle']").val(total_veh);
            $(".transport_type").val(transport_type);
            $(".source").val(source);
        }
        //total calculation
        function total_cal() {
            var total_pax=$("#form input[name~='total_pax']").val();
            var rate=$("#form input[name~='rate']").val();
            var vehicle=$("#form input[name~='total_vehicle']").val();
            $("#form input[name~='total']").val(Number(vehicle)*Number(rate));
        }

        function save_rec() {
            $.ajax({
                url:"<?php echo e(route('transport_confirimation.store')); ?>",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serialize(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#new").modal('hide');
                    get_data();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                }
            })
        }
        get_data();
        function get_data(page){
            $.ajax({
                url:"<?php echo e(url('BookingConfirmation/get_transport_confirimation')); ?>?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:$("#search-form").serialize(),
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'" class="'+(data.data[i].ack_by==null?'bg-warning':'')+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>uotqp'+data.data[i].id+'</td>';
                        htmlData+='<td>'+data.data[i].pax_name+'</td>';
                        htmlData+='<td>'+data.data[i].total_pax+'</td>';
                        htmlData+='<td>'+data.data[i].transport_date+'</td>';
                        htmlData+='<td>'+data.data[i].city_name+'</td>';
                        htmlData+='<td>'+data.data[i].fcity_name+'</td>';
                        htmlData+='<td>'+vehicle_type(data.data[i].transport_type)+'</td>';
                        htmlData+='<td>'+data.data[i].vehicle+'</td>';
                        htmlData+='<td>'+data.data[i].t_rate+'</td>';
                        htmlData+='<td>'+data.data[i].total+'</td>';
                        htmlData+='<td>'+data.data[i].remarks+'</td>';
                        htmlData+='<td>'+data.data[i].ack_by+'</td>';
                        htmlData+='<td class="noExl">';
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transport_confirmation_create')): ?>
                        htmlData+='<button class="btn btn-xs btn-primary" onclick="add_rate(\''+data.data[i].id+'\', \''+data.data[i].total_pax+'\', \''+data.data[i].vehicle+'\', \''+data.data[i].transport_type+'\', \''+data.data[i].source+'\')">Add Rate </button>';
                        <?php endif; ?>
                        htmlData+=' <a href="<?php echo e(url('agent_management/agent_umrah/')); ?>/'+data.data[i].UID+'" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> </a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                }
            })
        }
    </script>
    <script>
        var jq = $.noConflict();
        jq(document).ready(function(){
            $(".exportToExcel").click(function () {
                jq("#example2").table2excel({
                    filename: "Employees.xls",
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "transport_confirmation" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true,
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?><!-- jQuery -->
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/booking_confirmation/transport_confirmation/index.blade.php ENDPATH**/ ?>