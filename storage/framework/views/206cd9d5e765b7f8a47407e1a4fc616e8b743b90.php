<script type="text/javascript">
    $(function () {
        $(".select2").select2();
    });
    var agentID=$("#edit_agentID").val();
    //pax details
    function add_new_pax() {
        $("#new-pax").modal();
        document.getElementById("pax-form").reset();
        $("#pax-form input[name~='id']").val('');
        $(".select2").select2({
            placeholder: "Select",
        });
    }
    function ground_service(g) {
        var gs=$(g).find('option:selected').attr('data-val');
        var rate=$(g).find('option:selected').attr('data-rate');
        $.ajax({
            url:"<?php echo e(url('agent_management/get_ground_handleservices')); ?>/"+g,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            dataType:"JSON",
            success:function (data) {
                $('.note-editable').html(data.contact_details);
                $("form input[name~='ground_price']").val(data.rate);
            }
        });
//
    }
    //save complete umrah packages
    function save_umrah_rec(arg) {
        $("#loader").show();
        get_other_ground_information=$(".note-editable").html();
        var formData=$("#umrah-form").serializeArray();
        formData.push({"name":'other_ground_information',value:get_other_ground_information});
        $.ajax({
            url:"<?php echo e(route('agent_umrah.store')); ?>?arg="+arg,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$.param(formData),
            success:function (data) {
                $("#umrah-form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                window.location.href="<?php echo e(url('agent_management/umrah_details')); ?>/"+data.id;
                document.getElementById("umrah-form").reset();
                $("#loader").hide();
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#umrah-form input[name~='" + index + "']").css('border', '1px solid red');
                    $("#umrah-form select[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        });
    }
    function update_umrah_rec(arg) {
        $("#loader").show();
        get_other_ground_information=$(".note-editable").html();
        var formData=$("#umrah-form").serializeArray();
        formData.push({"name":'other_ground_information',value:get_other_ground_information});
        $("")
        $.ajax({
            url:"<?php echo e(url('agent_management/agent_umrah')); ?>/"+arg,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"PUT",
            dataType:"JSON",
            data:$.param(formData),
            success:function (data) {
                $("#umrah-form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                window.location.href="<?php echo e(url('agent_management/umrah_details')); ?>/"+data.id;
                    document.getElementById("umrah-form").reset();
                $("#loader").hide();
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#umrah-form input[name~='" + index + "']").css('border', '1px solid red');
                    $("#umrah-form select[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        });
    }
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $('#pax-form').submit(function (e) {
        var gender=$("#pax-form select[name~='gender']").val();
        var age=$("#age").val();
        var mehram=$("#mehram").val();
        if(mehram=='' && gender=='1' && age<40){
            toastr.error('You must joint to Mehram');
            return false;
        }
        if(mehram=='' && gender=='2' && age<45){
            toastr.error('You must joint to Mehram');
            return false;
        }
        $("#loader").show();
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "<?php echo e(url('agent_management/save_umrah_pax')); ?>",
            type: "POST",
            dataType: "JSON",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                htmlData = '';
                for (i in data) {
                    htmlData += '<tr id="' + data[i].passport + '">';
                    htmlData += '<td>' + (Number(i) + 1) + '</td>';
                    htmlData += '<td>' + data[i].pax_name + '</td>';
                    htmlData += '<td>N/A</td>';
                    htmlData += '<td>' + data[i].dob + '</td>';
                    htmlData += '<td></td>';
                    htmlData += '<td>' + data[i].passport + '</td>';
                    htmlData += '<td>' + data[i].vr + '<input type="hidden" class="visa_price" value="'+data[i].vr+'"></td>';
                    htmlData += '<td>' + data[i].flight_price+ '<input type="hidden" class="flight_price" value="'+data[i].flight_price+'"> </td>';
                    htmlData += '<td><input type="radio" name="group_leader" value="1"></td>';
                    htmlData += '<td>';
                    htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_pax(\'' + data[i].passport + '\')"><i class="fa fa-edit"></i> </a>';
                    htmlData += ' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\'' + data[i].passport + '\', \'<?php echo e(url('crm/save_umrah_pax/remove')); ?>/' + data[i].passport + '\')"><i class="fa fa-trash"></i> </a>';
                    htmlData += '</td>';
                    htmlData += '</tr>';
                }
                $("#get_pax_data").html(htmlData);
                total();
                $("#loader").hide();
            }, error: function (ajaxcontent) {
                vali = ajaxcontent.responseJSON.errors;
                var errors = '';
                $.each(vali, function (index, value) {
                    $("#pax-form input[name~='" + index + "']").css('border', '1px solid red');
                    $("#pax-form select[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    });
    });
    function edit_pax(id) {
        $("#new-pax").modal();
        $.ajax({
            url: "<?php echo e(url('agent_management/edit_upax')); ?>/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                for (i=0; i<Object.keys(data).length; i++){
                    $("#pax-form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    $("#pax-form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                }
//                $(".visa_cost").val(window.btoa(data.visa_cost));
                $("#pax-form input[name~='id']").val(id);
                $('.select2').select2();
                $("#new").find(".btn-success").text('Update');
            }
        })
    }
    $(document).on("change",".nights",function () {
        var g=$(this);
        var type=$(g).closest('.row').find('.room_type').val();
        var hID=$(g).closest('.row').find('.hotel').val();
        var checkin=$(g).closest('.row').find('.checkin').val();
        var checkout=$(g).closest('.row').find('.checkout').val();
        var arrangement=$(g).closest('.row').find('.arrangement').val();
        var nights=$(g).closest('.row').find('.nights').val();
        let agentID=$("#edit_agentID").val();
        var pax=$(g).closest('.row').find('.no_pax').val();
        if(arrangement==1) {
            $.ajax({
                url: "<?php echo e(url('agent_management/fetch_hotel_rate')); ?>",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data:{'type':type,'hID':hID, 'checkin':checkin, 'checkout':checkout,'agentID':agentID},
                success: function (data) {
                    if (data.agent_price.markup_type == 2) {
                        var markup = Number(data.agent_price.markup_value)*Number(nights);
                    }
                    if(data=='' || data.res_rate==0) {
                        $(g).closest('.row').find('.hotel_rate').val(0);
                        $(g).closest('.row').find('.hotel_cost').val(0);
                        $(g).closest('.row').find('.HRID').val(0);
                    }else {
                        if(type==7){
                            $(g).closest('.row').find('.hotel_rate').val(((Number(data.res_rate) + Number(markup)))*pax);
                            $(g).closest('.row').find('.hotel_net').val(((Number(data.res_rate) + Number(markup)))*pax);
                            $(g).closest('.row').find('.hotel_cost').val((Number(data.res_rate))*pax);
                            $(g).closest('.row').find('.HRID').val(data.agent_price.HRID);
                        }else
                        {
                            $(g).closest('.row').find('.hotel_rate').val((Number(data.res_rate) + Number(markup)));
                            $(g).closest('.row').find('.hotel_net').val((Number(data.res_rate) + Number(markup)));
                            $(g).closest('.row').find('.hotel_cost').val(Number(data.res_rate));
                            $(g).closest('.row').find('.HRID').val(data.agent_price.HRID);
                        }
                    }

                }
            });
        }
        setTimeout(function(){
            sum_hotels();
        }, 1000);
    })
    //fetch rate accordingly hotels
    function room_types(g) {
        var type=$(g).closest('.row').find('.room_type').val();
        var hID=$(g).closest('.row').find('.hotel').val();
        var checkin=$(g).closest('.row').find('.checkin').val();
        var checkout=$(g).closest('.row').find('.checkout').val();
        var arrangement=$(g).closest('.row').find('.arrangement').val();
        var nights=$(g).closest('.row').find('.nights').val();
        if(arrangement==1) {
            $.ajax({
                url: "<?php echo e(url('agent_management/fetch_hotel_rate')); ?>",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data:{'type':type,'hID':hID, 'checkin':checkin, 'checkout':checkout,'agentID':agentID},
                success: function (data) {
                    if (data.agent_price.markup_type == 2) {
                        var markup = Number(data.agent_price.markup_value)*Number(nights);
                    }
                    if(data=='' || data.res_rate==0) {
                        $(g).closest('.row').find('.hotel_rate').val(0);
                        $(g).closest('.row').find('.hotel_cost').val(0);
                        $(g).closest('.row').find('.HRID').val(0);
                    }else {
                        if(type==7){
                            $(g).closest('.row').find('.hotel_rate').val(((Number(data.res_rate) + Number(markup)))*pax);
                            $(g).closest('.row').find('.hotel_net').val(((Number(data.res_rate) + Number(markup)))*pax);
                            $(g).closest('.row').find('.hotel_cost').val((Number(data.res_rate))*pax);
                            $(g).closest('.row').find('.HRID').val(data.agent_price.HRID);
                        }else
                        {
                            $(g).closest('.row').find('.hotel_rate').val((Number(data.res_rate) + Number(markup)));
                            $(g).closest('.row').find('.hotel_net').val((Number(data.res_rate) + Number(markup)));
                            $(g).closest('.row').find('.hotel_cost').val(Number(data.res_rate));
                            $(g).closest('.row').find('.HRID').val(data.agent_price.HRID);
                        }
                    }

                }
            });
        }
        setTimeout(function(){
            sum_hotels();
        }, 1000);
    }
    function hotel_cal(g) {
        var arrngment=$(g).closest('.row').find(".arrangement").val();
        if(arrngment==1) {
            var room = $(g).closest('.row').find('.room').val();
            var rate = $(g).closest('.row').find('.hotel_rate').val();
//            var nights = $(g).closest('.row').find('.nights').val();
            $(g).closest('.row').find('.hotel_net').val(Number(room)* Number(rate));
            total();
        }
    }
    //sum of hotels
    function sum_hotels() {
        var sum=0;
        let conv_rate=$("#conversion_rate").val();
        $(".hotel_net").each(function () {
            sum +=+($(this).val()*conv_rate);
        });
        $("#hotel_total").text(sum);
        total();
    }
    //find checkout date
    function get_next_date(g) {
        var days=$(g).closest('.row').find('.nights').val();
        od=$(g).closest('.row').find('.checkin').val();
        var myDate=new Date(od);
        myDate.setDate(myDate.getDate()+Number(days));
        // format a date
        var dt =myDate.getFullYear()+'-'+ ("0" + (myDate.getMonth() + 1)).slice(-2)+'-'+("0" + (myDate.getDate())).slice(-2);
        $(g).closest('.row').find('.checkout').val(dt);
    }
    //append to new hotel
    function more_hotel() {
        $(".more-hotels").append('<div class="row">\
        <div class="col-md-1">\
            <div class="form-group">\
            <select class="form-control form-control-sm arrangement" name="arrangement[]">\
            <option value="1">Operator</option>\
            <option value="2">Agent</option>\
            <option value="3">Self</option>\
            </select>\
            </div>\
            </div><!--col-->\
            <div class="col-md-2">\
            <div class="form-group">\
            <select class="form-control form-control-sm select2" name="city[]" onchange="get_agnt_hotel(this)">\
            <option value="">Enter City Name</option>\
                <?php echo App\Models\City::ksa_cityList(); ?>\
        </select>\
        </div>\
        </div><!--col-->\
        <div class="col-md-2">\
            <div class="form-group">\
            <select class="form-control form-control-sm select2 hotel" onchange="hotel_cal(this)" name="hotel_id[]">\
            <option value="">Enter Hotel Name</option>\
        <?php echo App\Models\Hotel::dropdown(); ?>\
        </select>\
        </div>\
        </div><!--col-->\
        <div class="col-md-1">\
            <div class="form-group">\
        <select class="form-control form-control-sm select2 room_type" onchange="room_type(this)" name="room_type[]">\
            <option value="0">Single Type</option>\
            <?php echo App\Helpers\CommonHelper::room_type(); ?>\
        </select>\
        </div>\
        </div><!--col-->\
        <div class="col-md-1" style="max-width: 5% !important;">\
            <div class="form-group">\
            <input class="room form-control form-control-sm" placeholder="0" onchange="hotel_cal(this)" name="room[]">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1" style="max-width: 7% !important;">\
            <div class="form-group">\
        <input class="form-control form-control-sm no_pax" placeholder="0" name="no_pax[]">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input class="form-control form-control-sm checkin date" name="checkin[]">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input class="form-control form-control-sm nights" placeholder="0" name="nights[]" onchange="get_next_date(this),room_type(this)" value="1">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input class="form-control form-control-sm date checkout" name="checkout[]">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input class="form-control form-control-sm hotel_rate" readonly name="hotel_rate[]">\
            <input type="hidden" class="form-control form-control-sm HRID" name="HRID[]">\
            <input type="hidden" class="form-control form-control-sm hotel_cost" name="hotel_cost[]">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input class="form-control form-control-sm hotel_net" readonly name="hnet_rate[]">\
        </div>\
        </div><!--col-->\
        <div class="col-md-1">\
            <div class="form-group">\
            <button type="button" class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i> </button>\
            </div>\
            </div><!--col-->\
            </div><!--row-->');
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
    //append to new hotel
    function more_transport(g) {
        var transport_type=$(g).closest('.row').find('.transport_type ').val();
        $(".more-transports").append('<div class="row">\
            <div class="col-md-2">\
            <div class="form-group">\
            <select class="form-control form-control-sm arrangement" name="arrangement[]">\
            <option value="1">Operator</option>\
            <option value="2">Agent</option>\
            <option value="3">Self</option>\
            </select>\
            </div>\
            </div><!--col-->\
            <div class="col-md-2">\
            <div class="form-group">\
            <input type="text" class="form-control form-control-sm date" autocomplete="off" name="transport_date[]">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1">\
            <input type="text" autocomplete="off" class="form-control form-control-sm" name="transport_time[]" >\
            </div>\
            <div class="col-md-2">\
            <div class="form-group">\
        <select class="form-control form-control-sm select2 from_city" name="from_city[]">\
            <option value="">Enter City Name</option>\
            <?php echo App\Models\UmrahTransportCity::dropdown(); ?>\
        </select>\
        </div>\
        </div><!--col-->\
        <div class="col-md-2">\
            <div class="form-group">\
        <select class="form-control form-control-sm select2 to_city" name="to_city[]">\
            <option value="">Enter City Name</option>\
            <?php echo App\Models\Crm\UmrahTransportCity::dropdown(); ?>\
        </select>\
        </div>\
        </div><!--col-->\
        <div class="col-md-2">\
            <div class="form-group">\
        <select class="form-control form-control-sm select2 transport_type" name="transport_type[]" onchange= '+((transport_type==7)?'':"transport_rate(this)")+'>\
            <option value="">Select Type</option>\
            <?php echo App\Helpers\CommonHelper::vehicle_types(); ?>\
        </select>\
        </div>\
        </div><!--col-->\
        <div class="col-md-1">\
            <div class="form-group">\
        <input class="form-control form-control-sm no_of_pax" placeholder="0" name="no_pax[]">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input class="form-control form-control-sm no_vehcile" name="vehicle[]" onchange="transport_cal(this)" placeholder="0">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input class="form-control form-control-sm transport_rate" readonly value="0" name="trans_rate[]">\
            <input type="hidden" class="form-control form-control-sm TRID" name="TRID[]">\
            <input type="hidden" class="form-control form-control-sm transport_cost" name="transport_cost[]">\
            </div>\
            </div><!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input class="form-control form-control-sm transport_net" readonly name="net_rate[]">\
        </div>\
        </div><!--col-->\
        <div class="col-md-1">\
            <div class="form-group">\
            <button type="button" class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i> </button>\
            </div>\
            </div><!--col-->\
            </div><!--row-->');
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
    ////fetch rate accordingly transport
    function transport_rate(g) {
        var from_city=$(g).closest('.row').find('.from_city').val();
        var to_city=$(g).closest('.row').find('.to_city').val();
        var trans_type=$(g).closest('.row').find('.transport_type').val();
        var arrangement=$(g).closest('.row').find('.arrangement').val();
        var transport_date=$(g).closest('.row').find('.date').val();
        let agentID=$("#edit_agentID").val();
        //transport include in visa price
        var transport_include_visa=$("#transportvisacheck").prop("checked");
        var transport_check=$("#transportcheck").prop("checked");
        if(arrangement==1 && transport_include_visa==false && transport_check==true) {
            $.ajax({
                url: "<?php echo e(url('agent_management/fetch_transport_rate')); ?>",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data: {'from_city': from_city, 'to_city': to_city, 'trans_type': trans_type,'transport_date':transport_date,'agentID':agentID},
                success: function (data) {
                    if (data.agent_price[0] == 2) {
                        var markup = data.agent_price[1];
                    }
                   if(data=='' || data.res_rate==0){
                       $(g).closest('.row').find('.transport_rate').val(0);
                       $(g).closest('.row').find('.transport_cost').val(0);
                       $(g).closest('.row').find('.TRID').val(0);
                   }else {
                       $(g).closest('.row').find('.transport_rate').val((Number(data.res_rate) + Number(markup)));
                       $(g).closest('.row').find('.transport_cost').val(Number(data.res_rate));
                       $(g).closest('.row').find('.TRID').val(data.res.id);
                   }
                }
            });
            setTimeout(function(){
                sum_transports();
            }, 500);
        }else{
            $(g).closest('.row').find('.transport_rate').val(0);
            $(g).closest('.row').find('.transport_cost').val(0);
            $(g).closest('.row').find('.TRID').val(0);
        }
    }
    function transport_cal(g) {
        let conv_rate=$("#conversion_rate").val();
        var veh_type = $(g).closest('.row').find('.transport_type').val();
        if(veh_type==7 || veh_type==9) {
            var veh = $(g).closest('.row').find('.no_of_pax').val();
        }else{
            var veh = $(g).closest('.row').find('.no_vehcile').val();
        }
        var rate = $(g).closest('.row').find('.transport_rate').val();
        $(g).closest('.row').find('.transport_net').val(Number(veh)*Number(rate));
        sum_transports();
    }
    //sum of transport
    function sum_transports() {
        let conv_rate=$("#conversion_rate").val();
        var sum=0;
        $(".transport_net").each(function () {
            sum +=+($(this).val()*conv_rate);
        });
        $("#transport_total").text(sum);
        total();

    }
    function total() {
        var conv_rate=$("#conversion_rate").val();
        var sum=0;
        var tsum=0;
        var fsum=0;
        var vsum=0;
        $(".transport_net").each(function () {
            sum +=+($(this).val()*conv_rate);
        });
        $(".hotel_net").each(function () {
            tsum +=+($(this).val()*conv_rate);
        });
        $(".flight_price").each(function () {
            fsum +=+($(this).val()*conv_rate);
        });
        $("#total_flight").text(fsum);
        $(".visa_price").each(function () {
            vsum +=+($(this).val()*conv_rate);
        });
        $("#total_visa").text(vsum);
        $("#total").text(Number(sum)+Number(tsum)+Number(vsum)+Number(fsum));
    }
    //feth visa rate
    function visa_rate(g) {
        type=$(g).val();
        var agentID=$("#edit_agentID").val();
        $.ajax({
            url: "<?php echo e(url('agent_management/fetch_visa_rate')); ?>/"+type+"/"+agentID,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            success: function (data) {
                if(data.agent_price[0]==2){
                    var markup=data.agent_price[1];
                }
                if(type==1) {
                    $(g).closest('#pax-form').find('.visa_rate').val((Number($.parseJSON(data.res.adult_det.replaceAll("'", '')).net_sale)+ Number(markup)));
                    $(g).closest('#pax-form').find('.visa_cost').val((Number($.parseJSON(data.res.adult_det.replaceAll("'", '')).net_sale)));
                    $(g).closest('#pax-form').find('.VRID').val(data.res.id);
                }if(type==2){
                    $(g).closest('#pax-form').find('.visa_rate').val((Number($.parseJSON(data.res.child_det.replaceAll("'", '')).net_sale) + Number(markup)));
                    $(g).closest('#pax-form').find('.visa_cost').val((Number($.parseJSON(data.res.child_det.replaceAll("'", '')).net_sale)));
                    $(g).closest('#pax-form').find('.VRID').val(data.res.id);
                }if(type==3){
                    $(g).closest('#pax-form').find('.visa_rate').val((Number($.parseJSON(data.res.infant_det.replaceAll("'", '')).net_sale) + Number(markup)));
                    $(g).closest('#pax-form').find('.visa_cost').val((Number($.parseJSON(data.res.infant_det.replaceAll("'", '')).net_sale)));
                    $(g).closest('#pax-form').find('.VRID').val(data.res.id);
                }
            }
        });
    }
    $("#dep_date").on("focusout",function () {
        var date1 = $("#dep_arr").val();
        var date2 = $(this).val();
        var date1Updated = new Date(date1.replace(/-/g,'/'));
        var date2Updated = new Date(date2.replace(/-/g,'/'));
        const diffTime = Math.abs(date1Updated - date2Updated);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        $("#duration").val(diffDays);
    });
    $(".dob").on("change",function () {
        date1=$(this).val();
        dob = new Date(date1);
        var today = new Date();
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        $("#age").val(age);
    });
    //fetch agent visiotrs against group code
    function fetch_agent_visitors(g) {
        $("#visitor-list-modal").modal();
        let AID=$("#edit_agentID").val();
        $("#selected_agent_id").val(AID);
        var GID=$(g).val();
        if($("#visacheck").prop("checked")){
            var visa_price=1;
        }else{
            var visa_price=0;
        }
        $("#visitor_list_visa_price").val(visa_price);
        $.ajax({
            url:"<?php echo e(url('agent_management/fetch_agent_visitors')); ?>/"+GID,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            success:function (data) {
                htmlData = '';
                for (i in data) {
                    htmlData += '<tr id="' + data[i].passport + '">';
                    htmlData += '<td><input type="checkbox" class="select-mutamer" name="paxes[]" value="'+data[i].id+'"> ' + (Number(i) + 1) + '</td>';
                    htmlData += '<td>' + data[i].pax_name + '</td>';
                    htmlData += '<td>' + (data[i].gender==1?'Male':'Female') + '</td>';
                    htmlData+='<td>'+(data[i].pax_type==1?'Adult':'')+' '+(data[i].pax_type==2?'Child':'')+' '+(data[i].pax_type==3?'Infant':'')+'</td>';
                    htmlData += '<td>'+data[i].country_name+'</td>';
                    htmlData += '<td>' + data[i].passport + '</td>';
                    htmlData += '</tr>';
                }
                $("#get_group_pax_data").html(htmlData);
            }
        });
    }
    //Assign visiotr to vouchers
    function assign_visitor() {
        var linked_paxes='';
        $(".select-mutamer:checked").each(function () {
            linked_paxes +=$(this).val()+',';
        });
        $.ajax({
            url:"<?php echo e(url('agent_management/assigned_visitors')); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            data:$("#assign-visitor-form").serializeArray(),
            success:function (data) {
                htmlData = '';
                for (i in data) {
                    htmlData += '<tr id="' + data[i].passport + '">';
                    htmlData += '<td>' + (Number(i) + 1) + '</td>';
                    htmlData += '<td>' + data[i].pax_name + '</td>';
                    htmlData += '<td>N/A</td>';
                    htmlData += '<td>' + data[i].dob + '</td>';
                    htmlData += '<td></td>';
                    htmlData += '<td>' + data[i].passport + '</td>';
                    htmlData += '<td>' + data[i].vr + '<input type="hidden" class="visa_price" value="'+data[i].vr+'"></td>';
                    htmlData += '<td>' + data[i].flight_price+ '<input type="hidden" class="flight_price" value="'+data[i].flight_price+'"> </td>';
                    htmlData += '<td><input type="radio" name="group_leader" value="1"></td>';
                    htmlData += '<td>';
                    htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_pax(\'' + data[i].passport + '\')"><i class="fa fa-edit"></i> </a>';
                    htmlData += ' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\'' + data[i].passport + '\', \'<?php echo e(url('crm/save_umrah_pax/remove')); ?>/' + data[i].passport + '\')"><i class="fa fa-trash"></i> </a>';
                    htmlData += '</td>';
                    htmlData += '</tr>';
                }
                htmlData +='<tr><td><input type="hidden" name="linked_paxes" value="'+linked_paxes+'"><td></tr>';
                $("#get_pax_data").html(htmlData);
                $("#visitor-list-modal").modal('hide');
                total();
            }
        });
    }
    /*
    remove each row while creatieng umrah voucher
     */
    $(document).on("click",".remove",function () {
        $(this).closest('.tr').remove();
    });
    $(document).on('click',".remove",function () {
        $(this).closest('.row').remove();
        total();
        sum_hotels();
        sum_transports();
    });
    //fetch group list accordingly agents
    function fetch_agent_groups(id) {
        $.ajax({
            url:"<?php echo e(url('agent_management/fetch_agent_group')); ?>/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            success:function (data) {
                var htmlData='';
                htmlData+='<option value="0">Select Group</option>';
                for(i in data){
                    htmlData+='<option value="'+data[i].id+'">'+data[i].group_code+'-'+data[i].group_name+'</option>';
                }
                $(".agent_group").html(htmlData);
            }
        });
    }
    /*
    fethc hotel on the base of agent and city
     */
    function get_agnt_hotel(g) {
        let agentID=$("#edit_agentID").val();
        let citID=$(g).val();
        $.ajax({
            url:"<?php echo e(url('agent_management/get_agent_hotel')); ?>/"+agentID+"/"+citID,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            success:function (data) {
                $(g).closest('.row').find('.hotel').html('<option value="0">Select Hotel</option>'+data);
            }
        });
    }
</script>
<?php echo $__env->make('agents.agent_booking.search-option-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/agents/agent_booking/agent_umra_jsFunc.blade.php ENDPATH**/ ?>