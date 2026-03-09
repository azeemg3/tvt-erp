
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <style>
        .table-plain tbody tr,
        .table-plain tbody tr:hover,
        .table-plain tbody td {
            background-color:transparent;
            width: 100% !important;
        }
        .table-plain tbody td:first-child{
            border-right: transparent !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Umrah</li>
                            <li class="breadcrumb-item">Reservation</li>
                            <li class="breadcrumb-item active">Transport Reservation</li>
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
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-hover" style="font-size: 13px;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Source</th>
                                        <th>Brn</th>
                                        <th>Booking Date</th>
                                        <th>Transport Company</th>
                                        <th>Route</th>
                                        <th class="text-center">Sectors
                                            <table class="table-plain" style="width: 100% !important;">
                                                <tr>
                                                    <td style="width: 50% !important;">From</td>
                                                    <td style="width: 50% !important;">To</td>
                                                </tr>
                                            </table>
                                        </th>
                                        <th>Arrival Date</th>
                                        <th>Vehicle Type</th>
                                        <th data-toggle="tooltip" data-placement="top" title="Total Capacity"><i class="fa fa-user"></i> </th>
                                        <th data-toggle="tooltip" data-placement="top" title="Used Capacity for Visa"><i class="fa fa-user"></i> </th>
                                        <th data-toggle="tooltip" data-placement="top" title="Used Capacity for Traveller"><i class="fa fa-user"></i> </th>
                                        <th data-toggle="tooltip" data-placement="top" title="Available Capacity"><i class="fa fa-user"></i> </th>
                                        <th>Amount </th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="get_data"></tbody>
                                </table>
                            </div>
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
    <?php echo $__env->make('umrah.reservations.transport_reservation.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('umrah.group_details.transport-company-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        function add_new() {
            $("#transport-reservation").modal();
            $("select").select2({
                tags: true
            });
            $("select").on("select2:select", function (evt) {
                var element = evt.params.data.element;
                var $element = $(element);

                $element.detach();
                $(this).append($element);
                $(this).trigger("change");
            });
        }
        function save_rec() {
            $.ajax({
                url:"<?php echo e(route('transport_reservation.store')); ?>",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#trans-reservation-form").serialize(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    get_data(1);
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#trans-reservation-form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        }
        get_data();
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"<?php echo e(url('umrah/get_transport_reservation')); ?>?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#search-form").serialize(),
                success:function (data) {
                    htmlData='';
                    var j=data.per_page*data.current_page-50;
                    var k=data.per_page*data.current_page-50+1;
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(j)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].source.Trans_Acc_Name+'</td>';
                        htmlData+='<td>'+data.data[i].brn+'</td>';
                        htmlData+='<td>'+data.data[i].booking_date+'</td>';
                        htmlData+='<td>'+(data.data[i].trans_comp!=null ?''+data.data[i].trans_comp.name+'':'')+'</td>';
                        htmlData+='<td>'+data.data[i].trans_route.route+'</td>';
                        htmlData+='<td>';
                        for(j in $.parseJSON(data.data[i].sector_details)) {
                            htmlData += '<table class="table-plain">\
                            <tr>\
                                <td>'+$.parseJSON(data.data[i].sector_details)[j].from_city+'</td>\
                                <td>'+$.parseJSON(data.data[i].sector_details)[j].to_city+'</td>\
                                <td>'+$.parseJSON(data.data[i].sector_details)[j].sector_date+' \
                                '+$.parseJSON(data.data[i].sector_details)[j].sector_time+'\
                                </td>\
                            </tr>\
                            </table>';
                        }
                        htmlData+='</td>';
                        htmlData+='<td>'+data.data[i].arrival_date+'</td>';
                        htmlData+='<td>'+vehicle_type(data.data[i].vehicle_type)+'</td>';
                        htmlData+='<td>'+data.data[i].total_capacity+'</td>';
                        htmlData+='<td>0</td>';
                        htmlData+='<td>0</td>';
                        htmlData+='<td>48</td>';
                        htmlData+='<td>'+Number(data.data[i].total_capacity)*Number(data.data[i].purchase_rate)+'</td>';
                        htmlData+='<td>';
                        htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit(' + data.data[i].id + ')"><i class="fa fa-edit"></i> </a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                        j++;
                    }
                    $("#showing-entries").text('Showing '+(Number(k))+' to '+data.to+' of '+data.total+' entries').css('margin-right','5px');
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }
        function add_transport_compnay(g) {
            if(g=='new') {
                $("#transport-company").modal();
            }
        }
        function save_transport_company() {
            $.ajax({
                url:"<?php echo e(route('transport_company.store')); ?>",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#trans-comp-form").serialize(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    $("#transport-company").modal('hide');
                    $("#fetch_trans_company").append('<option selected value="'+data.id+'">'+data.name+'</option>');
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        }
        //add more sector in while adding transport brn
        //add more sector in while adding transport brn
        function more_transport_sector() {
            $(".more-tr-sectors").append('<div class="row">\
            <div class="col-md-2">\
            <div class="form-group">\
                <select name="from_city[]" class="form-control form-control-sm select2">\
                    <option value="">Select Sector</option>\
                    <?php echo App\Models\UmrahTransportCity::dropdown(); ?>\
                </select>\
            </div>\
            </div>\
            <!--col-->\
        <div class="col-md-2">\
            <div class="form-group">\
        <select name="to_city[]" class="form-control form-control-sm select2">\
            <option value="">Select Sector</option>\
        <?php echo App\Models\UmrahTransportCity::dropdown(); ?>\
        </select>\
        </div>\
        </div>\
        <!--col-->\
        <div class="col-md-2">\
            <input type="text" name="sector_date[]" class="form-control form-control-sm date" placeholder="Date">\
            </div>\
        <!--col-->\
        <div class="col-md-2">\
                <input type="time" name="sector_time[]" class="form-control form-control-sm">\
                </div>\
            <!--col-->\
        <div class="col-md-1">\
            <div class="form-group">\
        <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button>\
            </div>\
            </div>\
            <!--col-->\
            </div>\
            <!--row-->');
            $(".select2").select2();
            $('.date').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                startDate: true,
                minYear: 1930,
                maxYear: parseInt(moment().format('YYYY'),10),
                locale: {
                    format: 'YYYY-MM-DD',
                },
            });
            $(".date").on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-M-DD'));
            });
            $(".date").attr("autocomplete", "off");
        }
        function edit(id) {
            $("#transport-reservation").modal();
            $.ajax({
                url: "<?php echo e(url('umrah/transport_reservation')); ?>/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data.result).length; i++){
                        $("#trans-reservation-form input[name~='"+Object.keys(data.result)[i]+"']").val(Object.values(data.result)[i]);
                        $("#trans-reservation-form select[name~='"+Object.keys(data.result)[i]+"']").val(Object.values(data.result)[i]);
                    }
                    $(".more-tr-sectors").html(data.htmlData);
                    $('.select2').select2();
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?><!-- jQuery -->
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/umrah/reservations/transport_reservation/index.blade.php ENDPATH**/ ?>