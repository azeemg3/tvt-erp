
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
                            <li class="breadcrumb-item">Application Setup</li>
                            <li class="breadcrumb-item">Rate Setup</li>
                            <li class="breadcrumb-item active">Visa Rate List</li>
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
                            <form id="search-form">
                                <div class="row">
                                    <div class="col-md-2">
                                        <select name="visa_type" class="form-control form-control-sm select2">
                                            <option value="">Visa Type</option>
                                            <?php echo App\Helpers\CommonHelper::visa_type(); ?>

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="get_data(1)" class="btn btn-flat btn-xs btn-info"><i class="fas fa-search"></i> </button>
                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Visa Type</th>
                                    <th>Source</th>
                                    <th>Adult Price</th>
                                    <th>Child Price</th>
                                    <th>Infant Price</th>
                                    <th>Action</th>
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
    <?php echo $__env->make('Rate_setup.visa_rate.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function () {
            $(".select2").select2();
        });
        function add_new() {
            $("#new").modal();
            $(".more-item").html("");
            $(".more-item").append('<div class="row">\
                <div class="form-group col-md-4">\
                <select class="form-control form-control-sm select2 agent" name="agents[]">\
                <?php echo App\Models\Accounts\Agent::agent(); ?>\
                </select>\
                </div>\
                <div class="form-group col-md-2">\
                <select class="form-control form-control-sm" name="markup_type[]">\
                <option value="1">%</option>\
                <option value="2">Fixed</option>\
                </select>\
                </div>\
                <div class="col-md-2">\
                <input type="text" name="markup_value[]" class="form-control form-control-sm" placeholder="Enter...">\
                </div>\
                <div class="form-group col-md-1">\
                <button type="button" onclick="more_item()" class="btn btn-xs btn-primary">\
                <i class="fa fa-plus"></i> </button>\
                </div>\
                </div>');
            $(".select2").select2();
        }
        function save_rec() {
            $("#loader").show();
            $.ajax({
                url:"<?php echo e(route('visa_rate.store')); ?>",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serializeArray(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#new").modal('hide');
                    get_data();
                    $("#loader").hide();
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
        get_data();
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"<?php echo e(url('Application_Setup/Rate_Setup/get_visa_rate')); ?>?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#search-form").serialize(),
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+get_visa_type(data.data[i].visa_type)+'</td>';
                        htmlData+='<td>'+(data.data[i].source!=null?data.data[i].source.Trans_Acc_Name:'N/A')+'</td>';
                        htmlData+='<td>'+$.parseJSON(data.data[i].adult_det.replaceAll("'", '')).net_sale+'</td>';
                        htmlData+='<td>'+$.parseJSON(data.data[i].child_det.replaceAll("'", '')).net_sale+'</td>';
                        htmlData+='<td>'+$.parseJSON(data.data[i].infant_det.replaceAll("'", '')).net_sale+'</td>';
                        htmlData+='<td>';
                        htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit(' + data.data[i].id + ')"><i class="fa fa-edit"></i> Add Agent</a>';
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].id+'\', \'<?php echo e(url('Application_Setup/Rate_Setup/visa_rate')); ?>/'+data.data[i].id+'\')"><i class="fa fa-trash"></i> </a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }
        function edit(id) {
            $("#new").modal();
            $.ajax({
                url: "<?php echo e(url('Application_Setup/Rate_Setup/visa_rate')); ?>/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if(data.res.status==0){
                        $("#approve-first").show();
                    }
                    $("#form input[name~='id']").val(data.res.id);
                    $("#form select[name~='visa_type']").val(data.res.visa_type);
                    $("#form select[name~='source']").val(data.res.source);
                    $("#form select[name~='currency_id']").val(data.res.currency_id);
                    $("#form input[name~='currency_rate']").val(data.res.currency_rate);
                    $("#form input[name~='validity_from']").val(data.res.validity_from);
                    $("#form input[name~='validity_to']").val(data.res.validity_to);
                    $(".Apurchase_price").val($.parseJSON(data.res.adult_det.replaceAll("'", '')).purchae);
                    $(".Apurchase_price").closest('.row').find('.sale_tax').val($.parseJSON(data.res.adult_det.replaceAll("'", '')).sale_tax);
                    $(".Apurchase_price").closest('.row').find('.vat').val($.parseJSON(data.res.adult_det.replaceAll("'", '')).vat);
                    $(".Apurchase_price").closest('.row').find('.wh').val($.parseJSON(data.res.adult_det.replaceAll("'", '')).wh);
                    $(".Apurchase_price").closest('.row').find('.oc').val($.parseJSON(data.res.adult_det.replaceAll("'", '')).oc);
                    $(".Apurchase_price").closest('.row').find('.net_sale').val($.parseJSON(data.res.adult_det.replaceAll("'", '')).net_sale);
                    //child
                    $(".Cpurchase_price").val($.parseJSON(data.res.child_det.replaceAll("'", '')).purchase);
                    $(".Cpurchase_price").closest('.row').find('.sale_tax').val($.parseJSON(data.res.child_det.replaceAll("'", '')).sale_tax);
                    $(".Cpurchase_price").closest('.row').find('.vat').val($.parseJSON(data.res.child_det.replaceAll("'", '')).vat);
                    $(".Cpurchase_price").closest('.row').find('.wh').val($.parseJSON(data.res.child_det.replaceAll("'", '')).wh);
                    $(".Cpurchase_price").closest('.row').find('.oc').val($.parseJSON(data.res.child_det.replaceAll("'", '')).oc);
                    $(".Cpurchase_price").closest('.row').find('.net_sale').val($.parseJSON(data.res.child_det.replaceAll("'", '')).net_sale);
                    //infant
                    $(".Ipurchase_price").val($.parseJSON(data.res.infant_det.replaceAll("'", '')).purchase);
                    $(".Ipurchase_price").closest('.row').find('.sale_tax').val($.parseJSON(data.res.infant_det.replaceAll("'", '')).sale_tax);
                    $(".Ipurchase_price").closest('.row').find('.vat').val($.parseJSON(data.res.infant_det.replaceAll("'", '')).vat);
                    $(".Ipurchase_price").closest('.row').find('.wh').val($.parseJSON(data.res.infant_det.replaceAll("'", '')).wh);
                    $(".Ipurchase_price").closest('.row').find('.oc').val($.parseJSON(data.res.infant_det.replaceAll("'", '')).oc);
                    $(".Ipurchase_price").closest('.row').find('.net_sale').val($.parseJSON(data.res.infant_det.replaceAll("'", '')).net_sale);
                    $("#new").find(".btn-success").text('Update');
                    $(".more-item").html(data.data);
                    $('.select2').select2();
                }
            })
        }
        function more_item() {
            $(".more-item").append('<div class="row">' +
                '<div class="form-group col-md-4">'+
                '<select class="form-control form-control-sm select2 agent" name="agents[]">'+
                '<?php echo App\Models\Accounts\Agent::dropdown(); ?>'+
                '</select>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                '<select class="form-control form-control-sm" name="markup_type[]">'+
                '<option value="1">%</option>'+
                '<option value="2">Fixed</option>'+
                '</select>'+
                '</div>'+
                '<div class="col-md-2">'+
                '<input type="text" name="markup_value[]" class="form-control form-control-sm" placeholder="Enter...">'+
                '</div>'+
                '<div class="form-group col-md-1">' +
                '<button type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>'+
                '</div>'+
                '</div>');
            $(".select2").select2({
                placeholder: "Select",
            });
        }
        //toggle agent assign row
        $(document).ready(function() {
            //set initial state.
            $('.assign_to_agent').val(this.checked);
            $('.assign_to_agent').change(function () {
                if($(this).is(":checked")) {
                    $(".assign_to").show();
                }else{
                    $(".assign_to").hide();
                }
            });
        });
        function calculate_rate(g) {
            var pruchase=$(g).closest('.row').find('.purchase_price').val();
//            var sale=$(g).closest('.row').find('.sale_price').val();
            var sale_tax=$(g).closest('.row').find('.sale_tax').val();
            var vat=$(g).closest('.row').find('.vat').val();
            var wh=$(g).closest('.row').find('.wh').val();
            var oc=$(g).closest('.row').find('.oc').val();
            var net_sale=Number(pruchase)+Number(sale_tax)+Number(vat)+Number(wh)+Number(oc);
            $(g).closest('.row').find('.net_sale').val(net_sale);
        }
        //approved rate index while sent from service providor
        function approved_rate() {
            $("#loader").show();
            let id=$("#form input[name~='id']").val();
            $.ajax({
                url:"<?php echo e(url('Application_Setup/Rate_Setup/approve_visa_rate')); ?>/"+id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"GET",
                dataType:"JSON",
                success:function (data) {
                    if(data==1) {
                        toastr.success('Approved Successfully..');
                        $("#approve-first").hide();
                    }
                    $("#loader").hide();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#room-form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?><!-- jQuery -->
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/Rate_setup/visa_rate/index.blade.php ENDPATH**/ ?>