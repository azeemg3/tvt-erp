<script type="text/javascript">
    function add_new_sale(mID, mForm) {
        $("#"+mID).modal();
        $('#'+mID).find('form')[0].reset();
        $("#"+mID).find("form input[name~='id']").val(0);
        $("#"+mID).find("form input[name~='SID']").val(0);
        $(".SID").val(0);
        $("#"+mID).find(".btn-success").text('Submit');
        $(".select2").select2();
        $(".get_ticket_invDetails").html('');
        $(".get_hotel_invDetails").html('');
        $(".get_visa_invDetails").html('');
        $(".get_transport_invDetails").html('');
        $(".get_other_invDetails").html('');
        $(".tour_pax_list").html('')
    }
    $(document).ready(function () {
        $(".ticket-no").keyup(function () {
            if ($(this).val().length == 3) {
                $(this).val($(this).val() + "-");         }
            else if ($(this).val().length == 8) {
                $(this).val($(this).val()+ "-");
            }
        });
        //receiveable
        $(".basic_fare").keyup(function () {
            thisVal=$(this).val();
            taxes=$(this).closest("form").find(".taxes").val();
            if(taxes>0) {
                $(this).closest("form").find(".receiveable").val(Number(thisVal) + Number(taxes));
            }else{
                disc=$(this).closest("form").find(".discount").val();
                $(this).closest("form").find(".receiveable").val(Number(thisVal)-Number(disc));
            }
        });
        $(".discount").keyup(function () {
            thisVal=$(this).val();
            fare=$(this).closest("form").find(".basic_fare").val();
                $(this).closest("form").find(".receiveable").val(Number(fare) - Number(thisVal));
        });
        $(".taxes").keyup(function () {
            thisVal=$(this).val();
            taxes=$(this).closest("form").find(".basic_fare").val();
            $(this).closest("form").find(".receiveable").val(Number(thisVal)+Number(taxes));
        });
        //hide fields if type is not ticket
        $(".refund_to").change(function () {
            thisVal=$(this).val();
            g=$(this);
            if(thisVal!=1) {
                g.parents('form').find('.ref_airline, .ref_source, .ref_sector, .ref-sector, .ticket_no').hide();
            }else{
                g.parents('form').find('.ref_airline, .ref_source, .ref_sector, .ref-sector, .ticket_no').show();
            }

        })
    });
    //find checkout date
    function get_next_date(days) {
        od=$(".checkin").val();
        var myDate=new Date(od);
        myDate.setDate(myDate.getDate()+Number(days));
        // format a date
        var dt =myDate.getFullYear()+'-'+ ("0" + (myDate.getMonth() + 1)).slice(-2)+'-'+("0" + (myDate.getDate())).slice(-2);
        $(".checkout").val(dt);

    }
    //save sale invoices i.e. tikcets, hotels, visa, transport, tour, other
    function save_rec(routeStore, fData, type) {
        $("#loader").show();
        $.ajax({
            url:routeStore,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#"+fData).serialize(),
            success:function (data) {
                toastr.success('Operation Successfully..');
                $("#"+fData+ " input[name~='id']").val(0);
                $("#"+fData+ " input[name~='SID']").val(data);
                if(type=='ticket'){
                    get_ticket_invDetails(data, fData);
                }else if(type=='hotel'){
                    get_hotel_invDetails(data, fData);
                }else if(type=='visa'){
                    get_visa_invDetails(data, fData);
                }else if(type=='transport'){
                    get_transport_invDetails(data, fData);
                }else if(type=='other'){
                    get_other_invDetails(data, fData);
                }else if(type=='pcr'){
                    get_pcr_invDetails(data, fData);
                }
                $("#loader").hide();
                $("#"+fData).find(".btn-success").text('Submit');
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                if(ajaxcontent.responseJSON.success=='false'){
                    toastr.error('Something Wrong with your Request..!');
                }
                $.each(vali, function( index, value ) {
                    $("#"+fData+ " input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    }
    get_ticket_invoice(1);
    //fetch ticket invoice data
    function get_ticket_invoice(page) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_ticket_inv')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].id+'</td>';
                    htmlData+='<td>'+data.data[i].inv_date+'</td>';
                    htmlData+='<td>'+data.data[i].due_date+'</td>';
                    htmlData+='<td>'+data.data[i].totalPax+'</td>';
                    htmlData+='<td>'+data.data[i].total+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', \'ticket-modal\', \'1\')"><i class="fa fa-edit"></i> </a>';
                    htmlData+=' <a href="<?php echo e(url('lms/lead_ticket')); ?>/'+data.data[i].id+'" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-print"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_ticket_inv").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
    function get_ticket_invDetails(id, fData) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_ticket_invDetails')); ?>/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data){
                    htmlData+='<tr id="'+data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data[i].created_at+'</td>';
                    htmlData+='<td>'+data[i].pax_name+'</td>';
                    htmlData+='<td>'+data[i].pnr+'</td>';
                    htmlData+='<td>'+data[i].ticket_no+'</td>';
                    htmlData+='<td>'+data[i].basic_fare+'</td>';
                    htmlData+='<td>'+data[i].taxes+'</td>';
                    htmlData+='<td>'+data[i].receiveable+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_rec(this,'+data[i].id+', \'ticket-form\', \'<?php echo e(url('lms/lead_ticket')); ?>/' + data[i].id + '/edit\')"><i class="fa fa-edit"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#"+fData).parents('.modal').find('.get_ticket_invDetails').html(htmlData);
                $("#loader").hide();
            }
        })
    }
    function edit_rec(thisVal, id, formData, urlData) {
        $("#loader").show();
        fd=$(thisVal).parents('form').attr('id');
        if(fd==undefined){
            fd=formData;
        }
        $.ajax({
            url: urlData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                for (i=0; i<Object.keys(data).length; i++){
                    $("#"+fd+ " input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    $("#"+fd+ " select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);$("#"+formData+ " input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    $("#"+fd+ " textarea[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);$("#"+formData+ " input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                }
                $("#"+fd+ " .tour_pax_list").html('<option value="'+data.pax_name+'" selected>'+data.pax_name+'</option>')
                $('.select2').select2();
                $("#"+fd).find(".btn-success").text('Update');
                $("#loader").hide();
            }
        })
    }
    //edit tour record
    function edit_tour_rec(id, formData, urlData) {
        $("#loader").show();
        $.ajax({
            url: urlData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                for (i=0; i<Object.keys(data).length; i++){
                    if(Object.keys(data)[i]!='id') {
                        $("#tour-modal  input[name~='" + Object.keys(data)[i] + "']").val(Object.values(data)[i]);
                    }
                    $("#tour modal select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                }
                $('.select2').select2();
                $("#loader").hide();
            }
        })
    }
    //fetch hotel invoices as well invoices records
    function get_hotel_invoice(page) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_hotel_inv')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].id+'</td>';
                    htmlData+='<td>'+data.data[i].inv_date+'</td>';
                    htmlData+='<td>'+data.data[i].due_date+'</td>';
                    htmlData+='<td>'+data.data[i].totalPax+'</td>';
                    htmlData+='<td>'+data.data[i].total+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', hotels, \'2\')"><i class="fa fa-edit"></i> </a>';
                    htmlData+=' <a href="<?php echo e(url('lms/lead_hotel')); ?>/'+data.data[i].id+'" target="_blank"  class="btn btn-default btn-xs"><i class="fa fa-print"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_hotel_invoice").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
    function get_hotel_invDetails(id, fData) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_hotel_invDetails')); ?>/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data){
                    htmlData+='<tr id="'+data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data[i].created_at+'</td>';
                    htmlData+='<td>'+data[i].pax_name+'</td>';
                    htmlData+='<td>'+data[i].hotel.name+'</td>';
                    htmlData+='<td>'+data[i].checkin+'</td>';
                    htmlData+='<td>'+data[i].checkout+'</td>';
                    htmlData+='<td>'+data[i].nights+'</td>';
                    htmlData+='<td>'+data[i].rate_night+'</td>';
                    htmlData+='<td>'+data[i].receiveable+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_rec(this, '+data[i].id+', \'hotel-form\', \'<?php echo e(url('lms/lead_hotel')); ?>/' + data[i].id + '/edit\')"><i class="fa fa-edit"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#"+fData).parents('.modal').find('.get_hotel_invDetails').html(htmlData);
                $("#loader").hide();
            }
        })
    }
    //fetch visa invoice detials
    function get_visa_invoice(page) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_visa_inv')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].id+'</td>';
                    htmlData+='<td>'+data.data[i].inv_date+'</td>';
                    htmlData+='<td>'+data.data[i].due_date+'</td>';
                    htmlData+='<td>'+data.data[i].totalPax+'</td>';
                    htmlData+='<td>'+data.data[i].total+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', \'visa-modal\', \'3\')"><i class="fa fa-edit"></i> </a>';
                    htmlData+=' <a href="<?php echo e(url('lms/lead_visa')); ?>/'+data.data[i].id+'" target="_blank"  class="btn btn-default btn-xs"><i class="fa fa-print"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_visa_invoice").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
    function get_visa_invDetails(id, fData) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_visa_invDetails')); ?>/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data){
                    htmlData+='<tr id="'+data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data[i].created_at+'</td>';
                    htmlData+='<td>'+data[i].pax_name+'</td>';
                    htmlData+='<td>'+data[i].visa_no+'</td>';
                    htmlData+='<td>'+visa_type(data[i].visa_type)+'</td>';
                    htmlData+='<td>'+data[i].country.name+'</td>';
                    htmlData+='<td>'+data[i].receiveable+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_rec(this, '+data[i].id+', \'visa-form\', \'<?php echo e(url('lms/lead_visa')); ?>/' + data[i].id + '/edit\')"><i class="fa fa-edit"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#"+fData).parents('.modal').find('.get_visa_invDetails').html(htmlData);
                $("#loader").hide();
            }
        })
    }
    //fetch transport details.........
    function get_transport_invoice(page) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_transport_inv')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].id+'</td>';
                    htmlData+='<td>'+data.data[i].inv_date+'</td>';
                    htmlData+='<td>'+data.data[i].due_date+'</td>';
                    htmlData+='<td>'+data.data[i].totalPax+'</td>';
                    htmlData+='<td>'+data.data[i].total+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', \'transport-modal\', \'4\')"><i class="fa fa-edit"></i> </a>';
                    htmlData+=' <a href="#"  class="btn btn-default btn-xs"><i class="fa fa-print"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_transport_invoice").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
    function get_transport_invDetails(id) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_transport_invDetails')); ?>/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data){
                    htmlData+='<tr id="'+data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data[i].created_at+'</td>';
                    htmlData+='<td>'+data[i].pax_name+'</td>';
                    htmlData+='<td>'+pax_type(data[i].pax_type)+'</td>';
                    htmlData+='<td>'+vehicle_type(data[i].vehicle_type)+'</td>';
                    htmlData+='<td>'+data[i].receiveable+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_rec(this, '+data[i].id+', \'transport-form\', \'<?php echo e(url('lms/lead_transport')); ?>/' + data[i].id + '/edit\')"><i class="fa fa-edit"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#"+fData).parents('.modal').find('.get_transport_invDetails').html(htmlData);
                $("#loader").hide();
            }
        })
    }
    //fetch other invoice and ohter invoice details
    function get_other_invoice(page) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_other_inv')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].id+'</td>';
                    htmlData+='<td>'+data.data[i].inv_date+'</td>';
                    htmlData+='<td>'+data.data[i].due_date+'</td>';
                    htmlData+='<td>'+data.data[i].totalPax+'</td>';
                    htmlData+='<td>'+data.data[i].total+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', \'other-modal\', \'6\')"><i class="fa fa-edit"></i> </a>';
                    htmlData+=' <a href="#"  class="btn btn-default btn-xs"><i class="fa fa-print"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_other_invoice").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
    function get_other_invDetails(id, fData) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_other_invDetails')); ?>/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data){
                    htmlData+='<tr id="'+data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data[i].passport+'</td>';
                    htmlData+='<td>'+data[i].pax_name+'</td>';
                    htmlData+='<td>'+data[i].group_no+'</td>';
                    htmlData+='<td>'+vehicle_type(data[i].vehicle_type)+'</td>';
                    htmlData+='<td>'+data[i].receiveable+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_rec(this, '+data[i].id+', \'other-form\', \'<?php echo e(url('lms/lead_other')); ?>/' + data[i].id + '/edit\')"><i class="fa fa-edit"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#"+fData).parents('.modal').find('.get_other_invDetails').html(htmlData);
                $("#loader").hide();
            }
        })
    }
    //pcr test
    function get_pcr_invoice(page) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_pcr_invoice')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].id+'</td>';
                    htmlData+='<td>'+data.data[i].inv_date+'</td>';
                    htmlData+='<td>'+data.data[i].due_date+'</td>';
                    htmlData+='<td>'+data.data[i].totalPax+'</td>';
                    htmlData+='<td>'+data.data[i].total+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', \'pcr-modal\', \'10\')"><i class="fa fa-edit"></i> </a>';
                    htmlData+=' <a href="#"  class="btn btn-default btn-xs"><i class="fa fa-print"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_pcr_invoice").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
    function get_pcr_invDetails(id, fData) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_pcr_invDetails')); ?>/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data){
                    htmlData+='<tr id="'+data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data[i].pax_name+'</td>';
                    htmlData+='<td>'+pax_type(data[i].pax_type)+'</td>';
                    htmlData+='<td>'+data[i].lab_name+'</td>';
                    htmlData+='<td>'+data[i].receiveable+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_rec(this, '+data[i].id+', \'pcr-form\', \'<?php echo e(url('lms/lead_pcr_test')); ?>/' + data[i].id + '/edit\')"><i class="fa fa-edit"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#"+fData).parents('.modal').find('.get_pcr_invDetails').html(htmlData);
                $("#loader").hide();
            }
        })
    }
    //edit any type of invoice ticket, hotel, visa, transport, tour etc.
    function edit_invoice(id, divModal, type, SID) {
        $("#"+divModal).modal();
        fData=$("#"+divModal).find('form').attr('id');
        $("#"+divModal+" input[name~='SID']").val(id);
        $("input[name~='id']").each(function () {
            $(this).val(0);
        })
        if(type==1) {
            get_ticket_invDetails(id, fData);
        }
        else if(type==2 || type==5){
            get_hotel_invDetails(id, fData);
        } else if(type==3){
            get_visa_invDetails(id, fData);
        }else if(type==4){
            get_transport_invDetails(id, fData);
        }else if(type==6){
            get_other_invDetails(id, fData);
        }else if(type==10){
            get_pcr_invDetails(id, fData);
        }
        if(type==5){
            get_ticket_invDetails(id, fData);
            get_hotel_invDetails(id, fData);
            get_visa_invDetails(id, fData);
            get_transport_invDetails(id, fData);
            get_other_invDetails(id, fData);
        }
        $(".select2").select2();
        if(type==5) {
            edit_tour_rec(id, fData, '<?php echo e(url('lms/sale_invoice')); ?>/' + id + '/edit');
        }else{
            edit_rec(fData,id, fData, '<?php echo e(url('lms/sale_invoice')); ?>/' + id + '/edit');
        }
        if(type==7){
            $("#refund-modal").modal();
            $.ajax({
                url:'<?php echo e(url('lms/sale_invoice')); ?>/'+SID,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"GET",
                dataType:"JSON",
                data:$("#refund-form").serialize(),
                success:function (data) {
                    $("#refund-form input[name~='inv_date']").val(data.result.inv_date);
                    var htmlData='';
                    for(i in data.pax){
                        htmlData+='<option data-rec_id="'+data.pax[i].id+'" data-source="'+data.pax[i].source+'" data-airline="'+data.pax[i].airline+'" data-sector="'+data.pax[i].sector+'" data-ticket="'+data.pax[i].ticket_no+'" data-rec="'+data.pax[i].receiveable+'" value="'+data.pax[i].pax_name+'">'+data.pax[i].pax_name+'</option>';
                    }
                    $(".paxList").append(htmlData);
                    $("#loader").hide();
                }
            });
            edit_rec(fData,id, fData, '<?php echo e(url('lms/refund')); ?>/' + id + '/edit');
        }
        if(type==8){
            edit_rec(fData,id, fData, '<?php echo e(url('lms/receipt')); ?>/' + id + '/edit');
        }
        if(type==9){
            edit_rec(fData,id, fData, '<?php echo e(url('lms/client_doc')); ?>/' + id + '/edit');
        }
    }
    //close form
    function close_form(type) {
        if(type==1){
            get_ticket_invoice(1);
        }else if(type==2){
            get_hotel_invoice(1);
        }else if(type==3){
            get_visa_invoice(1);
        }else if(type==4){
            get_transport_invoice(1);
        }else if(type==5){
            get_tour_invoice(1);
        }else if(type==6){
            get_other_invoice(1);
        }else if(type==9){
            get_client_doc(1);
        }
    }
    //add more pax
    function more_pax() {
        $(".more_pax").append('<div class="row">' +
            '            <div class="form-group col-md-3">' +
            '            <input name="passport[]" class="form-control form-control-sm" placeholder="Passport">' +
            '            </div>' +
            '            <!--col-->' +
            '            <div class="form-group col-md-3">' +
            '       <input name="pax_name[]" class="form-control form-control-sm" placeholder="Passenger Name">' +
            '            </div>' +
            '            <!--col-->' +
            '            <div class="form-group col-md-3">' +
            '            <input name="mobile[]" class="form-control form-control-sm" placeholder="Mobile">' +
            '            </div>' +
            '            <!--col-->' +
            '<div class="form-group col-md-2">' +
            '       <select name="pax_type[]" class="form-control form-control-sm">' +
            '   <?php echo App\Helpers\CommonHelper::pax_type(); ?>'+
            '</select>            </div>'+

            '<!--col-->'+
            '<div class="col-md-1">' +
            '            <button type="button" class="btn btn-xs btn-danger btn-flat remove"><i class="fa fa-trash"></i> </button>' +
            '            </div>' +
            '            </div>');
    }
    $(document).on('click','.remove',function() {
        console.log($(this).closest('.row').remove());
    });
    //save tour pax in session
    function save_tour_pax() {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/tour_pax')); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#tour-pax-form").serializeArray(),
            success:function (data) {
                toastr.success('Operation Successfully..');
                $("#loader").hide();
                $(".select2").select2();
                var htmllist='';
                for(i in data.pax_name){
                    htmllist+='<option value="'+data.pax_name[i]+'">'+data.pax_name[i]+'</option>'
                }
                $(".tour_pax_list").html(htmllist);
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                if(ajaxcontent.responseJSON.success=='false'){
                    toastr.error('Something Wrong with your Request..!');
                }
                $.each(vali, function( index, value ) {
                    $("#tour-pax-form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }

        })
    }
    //save tour records like tickets, hotels, visa, transport, other etc.
    function save_tour_rec(routeStore, fData, type) {
        $("#loader").show();
        var SID=$(".SID").val();
        var leadID=$(".leadID").val();
        var inv_date=$(".inv_date").val();
        var due_date=$(".due_date").val();
        var payment_type=$(".payment_type").val();
        var remarks=$(".remarks").val();
        $.ajax({
            url:routeStore,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#"+fData).serialize()+'&inv_date='+inv_date+'&due_date='+due_date+'&payment_type='+payment_type+'&remarks='+remarks+"&leadID="+leadID+"&SID="+SID,
            success:function (data) {
                toastr.success('Operation Successfully..');
                $("#"+fData+ " input[name~='id']").val(0);
                $("#"+fData+ " input[name~='SID']").val(data);
                if(type=='ticket'){
                    get_ticket_invDetails(data, fData);
                }else if(type=='hotel'){
                    get_hotel_invDetails(data, fData);
                }else if(type=='visa'){
                    get_visa_invDetails(data, fData);
                }else if(type=='transport'){
                    get_transport_invDetails(data, fData);
                }else if(type=='other'){
                    get_other_invDetails(data, fData);
                }
                $(".SID").val(data);
                $("#loader").hide();
                $("#"+fData).find(".btn-success").text('Submit');
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                if(ajaxcontent.responseJSON.success=='false'){
                    toastr.error('Something Wrong with your Request..!');
                }
                $.each(vali, function( index, value ) {
                    $("#"+fData+ " input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        });
    }
    //get tour hotel invoice
    function get_tour_invoice(page) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_lead_tour')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].id+'</td>';
                    htmlData+='<td>'+data.data[i].inv_date+'</td>';
                    htmlData+='<td>'+data.data[i].due_date+'</td>';
                    htmlData+='<td>'+data.data[i].totalPax+'</td>';
                    htmlData+='<td>'+data.data[i].total+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', \'tour-modal\', \'5\')"><i class="fa fa-edit"></i> </a>';
                    htmlData+=' <a href="#"  class="btn btn-default btn-xs"><i class="fa fa-print"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_tour_invoice").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
    //crete refund request
    function save_refund() {
        $("#loader").show();
        $.ajax({
            url:'<?php echo e(route('refund.store')); ?>',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#refund-form").serialize(),
            success:function (data) {
                toastr.success('Operation Successfully..');
                $("#refund-form input[name~='id']").val(0);
                $("#loader").hide();
                $("#refund-form").find(".btn-success").text('Submit');
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
//                if(ajaxcontent.responseJSON.success=='false'){
//                    toastr.error('Something Wrong with your Request..!');
//                }
                $.each(vali, function( index, value ) {
                    $("#refund-form input[name~='" + index + "']").css('border', '1px solid red');
                    if(value==1062) {
                        toastr.error('Refund Already Exist Agaist this Record');
                        return false;
                    }
                    if(value!=1062 && value!=23000) {
                        toastr.error(value);
                    }
                });
                $("#loader").hide();
            }
        })
    }
    //fetch invoice details
    $(".inv_no").change(function () {
        $("#loader").show();
        SID=$(this).val();
        $.ajax({
            url:'<?php echo e(url('lms/sale_invoice')); ?>/'+SID,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            dataType:"JSON",
            success:function (data) {
                $("#refund-form input[name~='inv_date']").val(data.result.inv_date);
                var htmlData='';
                for(i in data.pax){
                    htmlData+='<option data-rec_id="'+data.pax[i].id+'" data-source="'+data.pax[i].source+'" data-airline="'+data.pax[i].airline+'" data-sector="'+data.pax[i].sector+'" data-ticket="'+data.pax[i].ticket_no+'" data-rec="'+data.pax[i].receiveable+'" value="'+data.pax[i].pax_name+'">'+data.pax[i].pax_name+'</option>';
                }
                $(".paxList").append(htmlData);
                $("#loader").hide();
            }
        })
    })
    //fetch pax details
    $(".paxList").change(function () {
        $(this).parents('form').find("input[name~='rec_id']").val($(this).find("option:selected").attr('data-rec_id'));
        $(this).parents('form').find("select[name~='source']").val($(this).find("option:selected").attr('data-source'));
        $(this).parents('form').find("select[name~='airline']").val($(this).find("option:selected").attr('data-airline'));
        $(this).parents('form').find("input[name~='sector']").val($(this).find("option:selected").attr('data-sector'));
        $(this).parents('form').find("input[name~='refund_sector']").val($(this).find("option:selected").attr('data-sector'));
        $(this).parents('form').find("input[name~='ticket_no']").val($(this).find("option:selected").attr('data-ticket'));
        $(this).parents('form').find("input[name~='refund_amount']").val($(this).find("option:selected").attr('data-rec'));
    });
    //fetch refunds
    function get_refunds(page) {
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_refunds')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].SID+'</td>';
                    htmlData+='<td>'+data.data[i].pax_name+'</td>';
                    htmlData+='<td>'+data.data[i].refund_date+'</td>';
                    htmlData+='<td>'+data.data[i].refund_amount+'</td>';
                    htmlData+='<td>'+data.data[i].service_charges+'</td>';
                    htmlData+='<td>'+(data.data[i].status==0?'Pending':'Approved')+'</td>';
                    htmlData+='<td>'+data.data[i].remarks+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', \'refund-modal\', \'7\', \''+data.data[i].SID+'\')"><i class="fa fa-edit"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_refunds").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
    //save receipt against lead id
    function save_receipt() {
        $("#loader").show();
        $.ajax({
            url:'<?php echo e(route('receipt.store')); ?>',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#receipt-form").serialize(),
            success:function (data) {
                toastr.success('Operation Successfully..');
                $("#receipt-form input[name~='id']").val(0);
                $("#receipt-form input[name~='SID']").val(data);
                $("#loader").hide();
                $("#receipt-form").find(".btn-success").text('Submit');
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                if(ajaxcontent.responseJSON.success=='false'){
                    toastr.error('Something Wrong with your Request..!');
                }
                $.each(vali, function( index, value ) {
                    $("#receipt-form input[name~='" + index + "']").css('border', '1px solid red');
                    $("#receipt-form textarea[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    }
    //fetch receipts details
    function get_receipts(page){
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_receipts')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+(data.data[i].id)+'</td>';
                    htmlData+='<td>'+data.data[i].particulars+'</td>';
                    htmlData+='<td>'+data.data[i].amount+'</td>';
                    htmlData+='<td>'+(data.data[i].status==0?'Pending':'Approved')+'</td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', \'receipt-modal\', \'8\', \''+data.data[i].id+'\')"><i class="fa fa-edit"></i> </a>';
                    htmlData+=' <a href="#"  class="btn btn-default btn-xs"><i class="fa fa-print"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_receipts").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
    //file upload
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#file-upload').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('client_doc.store')); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    toastr.success('Operation Successfully...');
                },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                if(ajaxcontent.responseJSON.success=='false'){
                    toastr.error('Something Wrong with your Request..!');
                }
                $.each(vali, function( index, value ) {
                    $(""+this+ " input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
            })
        });
    });
    //get client fiels
    function get_client_doc(page){
        $("#loader").show();
        $.ajax({
            url:"<?php echo e(url('lms/get_client_doc')); ?>?page="+page+"&leadID=<?php echo e($result[0]->id); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].doc_type+'</td>';
                    htmlData+='<td>'+data.data[i].e_number+'</td>';
                    htmlData+='<td>'+data.data[i].pax_name+'</td>';
                    htmlData+='<td><img src="<?php echo e(url('storage/app/')); ?>/'+data.data[i].doc_url+'" width="50"></td>';
                    htmlData+='<td>';
                    htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_invoice('+data.data[i].id+', \'document-modal\', \'9\')"><i class="fa fa-edit"></i> </a>';
                    htmlData+=' <a href="<?php echo e(url('storage/app/')); ?>/'+data.data[i].doc_url+'" download  class="btn btn-default btn-xs"><i class="fa fa-download"></i> </a>';
                    
                        htmlData+='</td>';
                    htmlData+='</tr>';
                }
                $("#get_lead_documents").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_ticket_invoice);
                $("#loader").hide();
            }
        })
    }
</script><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/Lms/sales/sale_js_func.blade.php ENDPATH**/ ?>