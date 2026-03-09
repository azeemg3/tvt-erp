

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
                            <li class="breadcrumb-item">Api Management</li>
                            <li class="breadcrumb-item">Flight</li>
                            <li class="breadcrumb-item active">Bookings</li>
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
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm date" placeholder="Date From">
                                    </div>
                                </div>
                                <!--col-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm date" placeholder="Date To">
                                    </div>
                                </div>
                                <!--col-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="" class="form-control form-control-sm">
                                            <option value="">Booking Type</option>
                                            <option value="">Ticket</option>
                                            <option value="">Hotel</option>
                                        </select>
                                    </div>
                                </div>
                                <!--col-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="" class="form-control form-control-sm">
                                            <option value="">Booking Status</option>
                                            <option value="">Pending</option>
                                            <option value="">Approved</option>
                                        </select>
                                    </div>
                                </div>
                                <!--col-->
                            </div>
                            <!--row-->
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#booking</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Arrive</th>
                                    <th>Depart</th>
                                    <th>Booking Type</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data">
                                <tr role="row" class="odd">
                                    <td><a href="<?php echo e(url('api_management/flight/1')); ?>">UR1987</a></td>
                                    <td>Shaheel</td>
                                    <td><a href="#">933322221</a></td>
                                    <td><a href="#">Shaheel@gmail.com</a></td>
                                    <td>11/06/2019</td>
                                    <td>15/06/2019</td>
                                    <td>Hotel</td>
                                    <td class="pending"><a href="#">Pending</a></td>
                                    <td class="unpaid"><a href="#">UnPaid</a></td>
                                    <td>
                                        <a href="#"><i class="fas fa-edit"></i></a>
                                        <a href="#"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td><a href="#">UR1987</a></td>
                                    <td>Shaheel</td>
                                    <td><a href="#">933322221</a></td>
                                    <td><a href="#">Shaheel@gmail.com</a></td>
                                    <td>11/06/2019</td>
                                    <td>15/06/2019</td>
                                    <td>Hotel</td>
                                    <td class="pending"><a href="#">Pending</a></td>
                                    <td class="unpaid"><a href="#">UnPaid</a></td>
                                    <td>
                                        <a href="#"><i class="fas fa-edit"></i></a>
                                        <a href="#"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td><a href="#">UR1987</a></td>
                                    <td>Shaheel</td>
                                    <td><a href="#">933322221</a></td>
                                    <td><a href="#">Shaheel@gmail.com</a></td>
                                    <td>11/06/2019</td>
                                    <td>15/06/2019</td>
                                    <td>Hotel</td>
                                    <td class="pending"><a href="#">Pending</a></td>
                                    <td class="unpaid"><a href="#">UnPaid</a></td>
                                    <td>
                                        <a href="#"><i class="fas fa-edit"></i></a>
                                        <a href="#"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="pagination-panel"></div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
    <?php echo $__env->make('agents.orders.edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
//        get_data();
        $(function () {
            $('.select2').select2();
        });
        function save_rec() {
            $.ajax({
                url:"<?php echo e(route('orders.store')); ?>",
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
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"<?php echo e(url('agent_management/get_orders')); ?>?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:$("#search-form").serialize(),
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].name+'</td>';
                        htmlData+='<td>'+data.data[i].pkg_name+'</td>';
                        htmlData+='<td>'+data.data[i].booking_date+'</td>';
                        htmlData+='<td>'+data.data[i].departure+'-'+data.data[i].arrival+'</td>';
                        htmlData+='<td>'+data.data[i].guest_price+'</td>';
                        htmlData+='<td>'+(data.data[i].status==1?'Approved':'Pending')+'</td>';
                        htmlData+='<td>';
                        htmlData += ' <a  class="btn btn-default btn-xs" href="javascript:void(0)" onclick="view('+data.data[i].id+')"><i class="fa fa-eye"></i> </a>';
                        htmlData += ' <a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit('+data.data[i].id+')"><i class="fa fa-edit"></i> </a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }
        function view(id) {
//            $("#loader").show();
            $("#view").modal();
            $.ajax({
                url:"<?php echo e(url('agent_management/orders')); ?>/"+id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"GET",
                dataType:"JSON",
                success:function (data) {
//                    $("#loader").hide();
//                    console.log(data.booking);
//                    $("")
                }
            })
        }
        function edit(id) {
            $("#loader").show();
            $("#edit-modal").modal();
            $.ajax({
                url: "<?php echo e(url('agent_management/orders')); ?>/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("#form input[name~='id']").val(data.booking.id);
                    $("#booking").text(data.booking.id);
                    $("#booking_date").text(data.booking.booking_date);
                    $("#form select[name~='airline_id']").val(data.booking.airline_id);
                    $("#form input[name~='pnr']").val(data.booking.pnr);
                    $("#form input[name~='flight']").val(data.booking.flight);
                    $("#form input[name~='departure']").val(data.booking.departure);
                    $("#form input[name~='departure_time']").val(data.booking.departure_time);
                    $("#form input[name~='arrival']").val(data.booking.arrival);
                    $("#form input[name~='arrival_time']").val(data.booking.arrival_time);
                    var tHtml='';
                    for(i in data.traveller) {
                        tHtml += '<tr>';
                        tHtml += '<td>'+data.traveller[i].first_name+' '+data.traveller[i].last_name+'</td>';
                        tHtml += '<td>'+data.traveller[i].mobile+'</td>';
                        tHtml += '<td>'+data.traveller[i].iqama_border_no+'</td>';
                        tHtml += '<td>'+data.traveller[i].passport_number+'</td>';
                        tHtml += '<td>'+data.traveller[i].nationality.name+'</td>';
                        tHtml += '<td>'+data.traveller[i].ticket_no+'</td>';
                        tHtml += '</tr>';
                    }
                    $("#passport_img").html('<img src="'+data.traveller[0].passport_images.split(',')[0]+'" style="width: 100%">');
                    $("#nic_images").html('<img src="'+data.traveller[0].nic_images.split(',')[0]+'" style="width: 100%">');
                    $("#traveller").html(tHtml);
                    $("#form select[name~='hotel_type']").val(data.AccDetails.hotel_type);
                    $("#form input[name~='hotel_name']").val(data.AccDetails.hotel_name);
                    $("#form input[name~='checkin']").val(data.AccDetails.checkin.split(' ')[0]);
                    $("#form input[name~='checkin_time']").val(data.AccDetails.checkin.split(' ')[1]);
                    $("#form input[name~='checkout']").val(data.AccDetails.checkout.split(' ')[0]);
                    $("#form input[name~='checkout_time']").val(data.AccDetails.checkout.split(' ')[1]);
                    $("#form select[name~='transport_type']").val(data.transport.transport_type);
                    $("#form select[name~='city']").val(data.transport.city);
                    $('.select2').select2();
                    $("#loader").hide();
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?><!-- jQuery -->
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/Api_managements/flights/bookings/index.blade.php ENDPATH**/ ?>