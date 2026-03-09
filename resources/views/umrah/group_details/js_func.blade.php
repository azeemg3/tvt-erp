<script>
    function add_new() {
        $("#new").modal();
        $("#form input[name~='id']").val(0);
        document.getElementById("form").reset();
        $(".select2").select2();
    }
    function add_mutamer(g) {
        get_visitor_data(g);
        $("#visitor-form").show();
        $("#pax-modal").modal();
        $("#pax-modal input[name~='group_id']").val(g);
        $(".select2").select2();
    }
    function hotel_brn(GID) {
        $("#hotel_brn-modal").modal();
        $(".select2").select2();
        $("#hotel_brn-modal input[name~='GID']").val(GID)
        $.ajax({
            url: "{{ url('umrah/edit_hotelBrn') }}/"+GID,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            success: function (data) {
                $(".more-hotel-brn").html(data.hotelBrn);
                $('.no_pax').each(function () {
                    $(this).val(data.total_pax);
                });
                $(".select2").select2();
            }
        });
    }
    function save_hotel_brn() {
        $.ajax({
            url:"{{ url('umrah/save_hotelbrn') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#hotelBrn-form").serializeArray(),
            success:function (data) {
                $("#form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById("hotel-reservation-form").reset();
                $("#hotel_brn-modal").modal('hide');
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                if(vali==undefined){
                    toastr.error('something wrong with your request');
                }
                $.each(vali, function( index, value ) {
                    $("#form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    }
    function transport_brn(GID) {
        $("#transport_brn-modal").modal();
        $("#transportBrn-form input[name~='GID']").val(GID);
        $.ajax({
            url: "{{ url('umrah/edit_transportBrn') }}/"+GID,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                $(".more-transport-brn").html(data.hotelBrn);
                $(".select2").select2();
            }
        });
    }
    function save_transport_brn(g) {
        $.ajax({
            url:"{{ url('umrah/save_transportbrn') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#transportBrn-form").serializeArray(),
            success:function (data) {
                $("#form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById("transportBrn-form").reset();
                $("#hotel_brn-modal").modal('hide');
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                if(vali==undefined){
                    toastr.error('Something Wrong with your request');
                }
                $.each(vali, function( index, value ) {
                    $("#transportBrn input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    }
    function hotel_reservation(g) {
        if($(g).val()=='new') {
            $("#hotel-reservation").modal();
            $(".select2").select2();
        }
    }
    //save hotel brn reservation details
    function save_hotel_res_brn() {
        $.ajax({
            url:"{{ route('hotel_reservation.store') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#hotel-reservation-form").serialize(),
            success:function (data) {
                $("#form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById("hotel-reservation-form").reset();
                $("#hotel-reservation").modal('hide');
                $("#fetch_hotel_brn").append('<option selected value="'+data.id+'">'+data.brn+'-'+data.booking_date+'</option>');
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
    function transport_reservation(g) {
        if(g=='new') {
            $("#transport-reservation").modal();
            $(".select2").select2();
        }
    }
    //save transport reservaton details
    function save_transport_res_brn() {
        $.ajax({
            url:"{{ route('transport_reservation.store') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#trans-reservation-form").serialize(),
            success:function (data) {
                $("#form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById("trans-reservation-form").reset();
                $("#transport-reservation").modal('hide');
                $("#fetch_transport_brn").append('<option selected value="'+data.id+'">'+data.brn+'-'+data.booking_date+'</option>');
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
    //Ground services details
    function add_gs(GID) {
        $("#ground-services-modal").modal();
        $("#gs-form input[name~='GID']").val(GID);
        $.ajax({
            url: "{{ url('umrah/edit_gground_service') }}/"+GID,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
//                $(".more-hotel-brn").html(data.hotelBrn);
                $("#ground-services-modal").find('.adult').val(data.adult);
                $("#ground-services-modal").find('.child').val(data.child);
                $("#ground-services-modal").find('.infant').val(data.infant);
            }
        });
        $(".select2").select2();
    }
    function save_gs() {
        $.ajax({
            url:"{{ url('umrah/save_group_det_service') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#gs-form").serializeArray(),
            success:function (data) {
                $("#form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById("transportBrn-form").reset();
                $("#hotel_brn-modal").modal('hide');
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#transportBrn input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    }
    //enter new ground services in details
    function add_new_gs_det(g) {
        if(g=='new') {
            $("#ground-service-details-modal").modal();
            var GID=$("#ground-services-modal input[name~='GID']").val();
            var adlt=$("#ground-services-modal").find('.adult').val();
            var chld=$("#ground-services-modal").find('.child').val();
            var infnt=$("#ground-services-modal").find('.infant').val();
            $("#ground-service-details-modal").find('.GID').val(GID);
            $("#ground-service-details-modal input[name~='adult_qty']").val(adlt);
            $("#ground-service-details-modal input[name~='child_qty']").val(chld);
            $("#ground-service-details-modal input[name~='infant_qty']").val(infnt);
        }
        $(".select2").select2();
    }
    function save_new_gs_det() {
        $.ajax({
            url:"{{ route('ground_services.store') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#ground-det-form").serialize(),
            success:function (data) {
                $("#ground-det-form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById("trans-reservation-form").reset();
                $("#ground-service-details-modal").modal('hide');
                $("#fetch_gs").append('<option selected value="'+data.id+'">'+data.company_name+'</option>');
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#ground-det-form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    }
    //============End===
    function add_mofa(g, group_no, group_name) {
        $("#mofa-modal").modal();
        $("#mofa-modal input[name~='group_no']").val(group_no);
        $("#mofa-modal input[name~='group_name']").val(group_name);
        get_mofa_det(g);
    }
    function more_hotel_brn() {
        $(".more-hotel-brn").append('<div class="row">\
            <div class="col-md-3">\
            <div class="form-group">\
        <select name="HTBRN[]" class="form-control form-control-sm select2" onchange="hotel_reservation(this), available_hotel_capacity(this)">\
            <option value="">--Select--</option>\
            <option value="new">Add New</option>\
            {!! App\Models\Umrah\HotelReservationBrn::dropdown() !!}\
        </select>\
        </div>\
        </div>\
        <!--col-->\
        <div class="col-md-2">\
            <div class="form-group">\
        <select name="" disabled class="form-control form-control-sm select2 room_type" id="fetch_hotel_brn" onchange="hotel_reservation(this)">\
            <option value="">--Select--</option>\
                {!! App\Models\RoomType::dropdown() !!}\
            </select>\
            </div>\
            </div>\
        <!--col-->\
        <div class="col-md-1">\
            <div class="form-group">\
        <input type="text" disabled class="form-control form-control-sm no_room" placeholder="Enter...">\
            </div>\
            </div>\
        <!--col-->\
        <div class="col-md-1">\
            <div class="form-group">\
        <input type="text" disabled class="form-control form-control-sm no_beds" placeholder="Enter...">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
        <input type="text" name="no_pax[]" class="form-control form-control-sm no_pax" placeholder="Enter...">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-2">\
            <div class="form-group">\
            <button type="button" class="btn btn-xs btn-danger remove"><i class="fa fa-trash"></i> </button>\
            </div>\
            </div>\
            <!--col-->\
            </div>');
        $(".select2").select2();
    }
    function more_trans_brn() {
        $(".more-transport-brn").append('<div class="row">\
            <div class="col-md-7">\
            <div class="form-group">\
        <select name="TRBRN[]" class="form-control form-control-sm select2" onchange="hotel_reservation(this)">\
            <option value="">--Select--</option>\
            <option value="new">Add New</option>\
        </select>\
        </div>\
        </div>\
        <!--col-->\
        <div class="col-md-2">\
            <div class="form-group">\
        <input type="text" name="no_pax[]" class="form-control form-control-sm" placeholder="Enter...">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-2">\
            <div class="form-group">\
            <input type="text" readonly name="" class="form-control form-control-sm" placeholder="Enter...">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <button type="button" class="btn btn-xs btn-danger remove"><i class="fa fa-trash"></i> </button>\
            </div>\
            </div>\
            <!--col-->\
            </div>');
        $(".select2").select2();
    }
    function save_rec() {
        $("#loader").show();
        $.ajax({
            url:"{{ route('group_details.store') }}",
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
            url:"{{ url('umrah/get_group_details') }}?page="+page,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#search-form").serialize(),
            success:function (data) {
                htmlData='';
                var j=data.per_page*data.current_page-50;
                var k=data.per_page*data.current_page-50+1;
                let total_motamer=0;
                let total_linked=0;
                let total_mofa=0;
                let total_hbrn=0;
                let total_tbrn=0;
                let total_gs=0;
                for(i in data.data){
                    total_motamer +=Number(data.data[i].total_visitors);
                    total_linked +=Number(data.data[i].linked_pax);
                    total_mofa +=Number(data.data[i].total_mofa);
                    total_hbrn +=Number(data.data[i].total_hotelBrn);
                    total_tbrn +=Number(data.data[i].total_transBrn);
                    total_gs +=Number(data.data[i].total_gs);
                    htmlData+='<tr id="'+data.data[i].id+'" class="'+(data.data[i].linked_pax>0?'bg-lightblue color-palette':'')+'">';
                    htmlData+='<td>'+(Number(j)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].agent_name+'</td>';
                    htmlData+='<td>'+data.data[i].country_name+'</td>';
                    htmlData+='<td>'+data.data[i].group_code+'</td>';
                    htmlData+='<td>'+data.data[i].group_name+'</td>';
                    htmlData+='<td>'+data.data[i].embassy+'</td>';
                    htmlData+='<td>'+data.data[i].voucher+'</td>';
                    htmlData+='<td><a href="#" onclick="add_voucher_amount(\''+data.data[i].id+'\')">'+Number(data.data[i].total_amount).toFixed(2)+'</a> </td>';
                    htmlData+='<td><a href="#" onclick="add_mutamer(\''+data.data[i].id+'\')">'+data.data[i].linked_pax+'/'+data.data[i].total_visitors+'</a></td>';
                    htmlData+='<td><a href="#" onclick="add_mofa(\''+data.data[i].id+'\', \''+data.data[i].group_code+'\', \''+data.data[i].group_name+'\')">'+data.data[i].total_mofa+'</a></td>';
                    htmlData+='<td><a href="#" onclick="hotel_brn(\''+data.data[i].id+'\')">'+data.data[i].total_hotelBrn+'</a></td>';
                    htmlData+='<td><a href="#" onclick="transport_brn(\''+data.data[i].id+'\')">'+data.data[i].total_transBrn+'</a></td>';
                    htmlData+='<td><a href="#" onclick="add_gs(\''+data.data[i].id+'\')">'+data.data[i].total_gs+'</a></td>';
                    htmlData+='<td>'
                    htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit(' + data.data[i].id + ')"><i class="fa fa-edit"></i> </a>';
                    htmlData+='</td>';
                    htmlData+='</tr>';
                    j++;
                }
                $("#showing-entries").text('Showing '+(Number(k))+' to '+data.to+' of '+data.total+' entries').css('margin-right','5px');
                htmlData+='<tr>' +
                    '<th colspan="7" style="text-align:right">Total:</th>' +
                        '<td></td>' +
                        '<th>'+total_linked+'/'+total_motamer+'</th>' +
                        '<td>'+total_mofa+'</td>' +
                        '<td>'+total_hbrn+'</td>' +
                        '<td>'+total_tbrn+'</td>' +
                        '<td>'+total_gs+'</td>' +
                        '<td></td>' +
                    '</tr>';
                $("#get_data").html(htmlData);
                pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                $("#loader").hide();
            }
        })
    }
    function edit(id) {
        $("#new").modal();
        $.ajax({
            url: "{{ url('umrah/group_details') }}/" + id + "/edit",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                for (i=0; i<Object.keys(data).length; i++){
                    $("#form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    $("#form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                }
                $('.select2').select2();
                $("#new").find(".btn-success").text('Update');
            }
        })
    }
    //save visitors
    $('#visitor-form').submit(function (e) {
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
            url: "{{ url('umrah/save_visitor') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            dataType: "JSON",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#visitor-form input[name~='id']").val(0);
                var GIB=$("#visitor-form input[name~='group_id']").val();
                toastr.success('Operation Successfully..');
                $("#loader").hide();
                get_visitor_data(GIB);
            }, error: function (ajaxcontent) {
                vali = ajaxcontent.responseJSON.errors;
                var errors = '';
                $.each(vali, function (index, value) {
                    $("#visitor-form input[name~='" + index + "']").css('border', '1px solid red');
                    $("#visitor-form select[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    });
    //fetch visitor data
    function get_visitor_data(GID) {
        $.ajax({
            url:"{{ url('umrah/get_visitor_data') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:{'GID':GID},
            success:function (data) {
                htmlData='';
                for(i in data){
                    htmlData+='<tr id="vis_'+data[i].id+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data[i].pax_name+'</td>';
                    htmlData+='<td>'+(data[i].gender==1?'Male':'Female')+'</td>';
                    htmlData+='<td>'+(data[i].pax_type==1?'Adult':'')+' '+(data[i].pax_type==2?'Child':'')+' '+(data[i].pax_type==3?'Infant':'')+'</td>';
                    htmlData+='<td>'+data[i].country.name+'</td>';
                    htmlData+='<td>'+data[i].passport+'</td>';
                    htmlData += '<td>';
                    htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_pax(\'' + data[i].id + '\')"><i class="fa fa-edit"></i> </a>';
                    htmlData += ' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_visitor(\'' + data[i].id + '\', \'{{ url('umrah/remove_visitor') }}/' + data[i].id + '\')"><i class="fa fa-trash"></i> </a>';
                    htmlData += '</td>';
                    htmlData+='</tr>';
                }
                $("#get_visitor_data").html(htmlData);
            }
        })
    }
    //fetch mofa detials
    function get_mofa_det(GID) {
        $.ajax({
            url:"{{ url('umrah/get_visitor_data') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:{'GID':GID},
            success:function (data) {
                htmlData='';
                for(i in data){
                    htmlData+='<tr id="'+data[i].id+'">';
                    htmlData+='<td>'+((1)+(i))+'</td>';
                    htmlData+='<td>'+data[i].pax_name+'</td>';
                    htmlData+='<td><input type="text" name="" value="'+data[i].mofa+'" class="form-control-sm form-control mofa" placeholder="#MOFA">' +
                        '<input type="hidden" class="group_id" value="'+data[i].id+'">'+
                        '</td>';
                    htmlData+='<td><input type="text" name="" value="'+data[i].visa+'" class="form-control form-control-sm visa" placeholder="#Visa"></td>';
                    htmlData+='<td>'+(data[i].gender==1?'Male':'Female')+'</td>';
                    htmlData+='<td>'+data[i].dob+'</td>';
                    htmlData+='<td>'+data[i].country.name+'</td>';
                    htmlData+='<td>'+data[i].passport+'</td>';
                    htmlData+='<td>'+data[i].mehram+'</td>';
                    htmlData+='<td>N/A</td>';
                    htmlData+='<td class="visa_attached" data-visa="'+data[i].visa_attachment+'">'+(data[i].visa_attachment==null?'<input class="visa_attachment" type="file">':'<a href="'+data[i].visa_attachment+'" download=""><i class="fa fa-download"> </a>')+'</td>';
                    htmlData += '<td>';
                    htmlData += '<button type="button" class="btn btn-xs btn-success save_mofa">Save</button>';
                    htmlData += '</td>';
                    htmlData+='</tr>';
                }
                $("#get_mofa_data").html(htmlData);
            }
        })

    }
    //edit visitors
    function edit_pax(id) {
        $.ajax({
            url: "{{ url('umrah/edit_pax') }}/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                for (i=0; i<Object.keys(data).length; i++){
                    $("#visitor-form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    $("#visitor-form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                }
//                $(".visa_cost").val(window.btoa(data.visa_cost));
                $("#visitor-form input[name~='id']").val(id);
                $('.select2').select2();
                $("#new").find(".btn-success").text('Update');
            }
        });
    }
    $(function() {
        $('.dob').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),11)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            $("#age").val(years);
        });
        $(".dob").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });
        $(".dob").attr("autocomplete", "off");
    });
    //save mofa details
    $(document).on("click", ".save_mofa",function () {
        var dataimg = new FormData();
        if($(this).closest('tr').find(".visa_attached").attr('data-visa')=='null') {
            dataimg.append('visa_attachment', $(this).closest('tr').find(".visa_attachment")[0].files[0]);
        }
        dataimg.append('visa', $(this).closest('tr').find(".visa").val());
        dataimg.append('mofa', $(this).closest('tr').find(".mofa").val());
        dataimg.append('id', $(this).closest('tr').find(".group_id").val());
        var g=$(this);
        $.ajax({
            url: "{{ url('umrah/save_mofa_details') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            dataType: "JSON",
            data: dataimg,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if(data.visa_attachment!=null) {
                    $(g).closest('tr').find(".visa_attached").html('<a href="' + data + '" download=""><i class="fa fa-download"> </a>');
                }
                toastr.success('Operation Successfully..');
            }
        });

    });
    $(document).on("click",".remove",function () {
        $(this).closest('.row').remove();
    });
    //add new transport company
    function add_transport_compnay(g) {
        if(g=='new') {
            $("#transport-company").modal();
        }
    }
    function save_transport_company() {
        $.ajax({
            url:"{{ route('transport_company.store') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#trans-comp-form").serialize(),
            success:function (data) {
                $("#form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById("hotel-reservation-form").reset();
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
    //====================Voucher amount------------------
    function add_voucher_amount(g) {
        $("#loader").show();
        $("#voucher-modal").modal();
        $("#voucher-modal input[name~='GID']").val(g);
        $.ajax({
            url:"{{ url('umrah/edit_gv/') }}/"+g,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"GET",
            dataType:"JSON",
            success:function (data) {
                if(data.result!=null) {
                    $("#group_voucher-form input[name~='id']").val(data.result.id);
                    $("#group_voucher-form input[name~='voucher']").val(data.result.voucher);
                    $("#group_voucher-form select[name~='currency']").val(data.result.currency);
                    $("#group_voucher-form input[name~='currency_rate']").val(data.result.currency_rate);
                    $("#get_hotel_data").html(data.htmlHotel);
                    $("#get_transport_data").html(data.transportHtml);
                    $("#get_other_services").html(data.otherHtml);
                    $(".select2").select2();
                    var sum = 0;
                    $(".total").each(function () {
                        sum += Number($(this).val());
                    });
                    $(".total_amount").val(sum);
                }
                $("#hotelBrn").html('<option value="">Select</option>'+data.hotelBrn);
                $("#trnsportBrn").html('<option value="">Select</option>'+data.transportBrn);
                $("#otherServices").html('<option value="">Select</option>'+data.otherServices);
                $("#loader").hide();
            }
        });
        $(".select2").select2();
    }
    //more hotel voucher reservation
    function more_hotel_gv(g) {
        $(g).closest('tr').clone().appendTo("#more_hote_gv");
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
    function more_transport_gv(g) {
        $(g).closest('tr').clone().appendTo("#get_transport_data");
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
    //more other services
    function more_os_gv(g) {
        $(g).closest('tr').clone().appendTo("#more_os_gv");
//        $("#more_os_gv").append('<tr>\
//            <td><input type="text" name="Oservice_name[]" class="form-control form-control-sm" placeholder="Service Name"></td>\
//            <td><input type="text" name="Oprice[]" class="form-control form-control-sm price" placeholder="Price"></td>\
//            <td><input type="text" name="Oqty[]" class="form-control form-control-sm qty" placeholder="Qty"></td>\
//            <td><input type="text" name="Ototal_amount[]" class="form-control form-control-sm total" placeholder="Amount"></td>\
//            <td><button type="button" class="btn btn-danger btn-xs remove-gv"><i class="fa fa-trash"></i> </button></td>\
//            </tr>');
        $(".select2").select2();
    }
    //more repersentative
    function more_repersentative() {
        $("#more_repersentative").append('<div class="row">\
            <div class="col-md-3">\
            <div class="form-group">\
            <select name="city_id[]" class="form-control form-control-sm select2">\
                <option value="">Select City</option>\
                {!! App\Models\City::dropdown() !!}\
            </select>\
        </div>\
        </div>\
        <!--col-->\
        <div class="col-md-3">\
            <div class="form-group">\
                <input type="text" name="repersentative_person" class="form-control form-control-sm">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-4">\
            <div class="form-group">\
        <input type="text" name="repersentative_contact" class="form-control form-control-sm">\
            </div>\
            </div>\
            <!--col-->\
            <!--<div class="col-md-1">\
            <div class="form-group">\
            <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> </button>\
            </div>\
            </div>-->\
            <!--col-->\
            </div>\
            <!--row-->');
        $(".select2").select2();
    }
    $(document).on("click",".remove-gv",function () {
        $(this).closest('tr').remove();
    });
    //save group voucher
    function save_group_voucher() {
        $.ajax({
            url:"{{ url('umrah/save_group_voucher') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#group_voucher-form").serializeArray(),
            success:function (data) {
                $("#group_voucher-form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById("group_voucher-form").reset();
                get_data();
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#group_voucher-form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        });
    }
    //=====================================================End===================================
    $(document).on("keyup",".price",function () {
        var sum=0;
        var price=$(this).closest('tr').find('.price').val();
        var qty=$(this).closest('tr').find('.qty').val();
        var total_amount=$(this).closest('tr').find('.total').val(Number(price)*Number(qty));
        $(".total").each(function () {
            sum += Number($(this).val());
        });
        $(".total_amount").val(sum);
    });
    $(document).on("keyup",".qty",function () {
        var sum=0;
        var price=$(this).closest('tr').find('.price').val();
        var qty=$(this).closest('tr').find('.qty').val();
        $(this).closest('tr').find('.total').val(Number(price)*Number(qty));
        $(".total").each(function () {
            sum += Number($(this).val());
        });
        $(".total_amount").val(sum);
    });
    function service_type(g) {
        if(g==2){
            //ground services type
            $("#gs_type").show();
        }else{
            $("#gs_type").hide();
        }
    }
    //add more services
    function more_services() {
        $(".more-services").append('<div class="row add_service_cal">\
            <div class="col-md-2">\
            <div class="form-group">\
                <select name="service_name[]" class="form-control form-control-sm service">\
                <option value="">Select</option>\
                    {!! App\Helpers\CommonHelper::additional_services() !!}\
                </select>\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input type="number" name="aadult_rate[]" class="aadult_rate form-control form-control-sm" placeholder="0.00">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input type="number" name="achild_rate[]" class="achild_rate form-control form-control-sm" placeholder="0.00">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input type="number" name="ainfant_rate[]" class="ainfant_rate form-control form-control-sm" placeholder="0.00">\
            <input type="hidden" name="got_services_by[]" class="form-control form-control-sm got_services_by">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input type="number" name="aadult_qty[]" readonly class="aadult_qty aadult_qty form-control form-control-sm" placeholder="0">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input type="number" name="achild_qty[]" readonly class="achild_qty achild_qty form-control form-control-sm" placeholder="0">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
            <div class="form-group">\
            <input type="number" name="ainfant_qty[]" readonly class="ainfant_qty ainfant_qty form-control form-control-sm" placeholder="0">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
                <div class="form-group">\
                <input type="number" name="total_service_amount[]" readonly class="form-control form-control-sm total_service_amount" placeholder="0.00">\
                </div>\
            </div>\
            <!--col-->\
            <div class="col-md-2">\
                <input type="text" readonly class="form-control form-control-sm service_linked_pax">\
            </div>\
            <!--col-->\
            \<div class="col-md-1">\
            <div class="form-group">\
            <button type="button" class="btn btn-xs btn-danger remove"><i class="fa fa-trash"></i> </button>\
            <button type="button" onclick="open_visitor_list(1, this)" class="btn btn-xs btn-outline-warning"><i class="fa fa-user"></i> </button>\
            </div>\
            </div>\
            <!--col-->\
            </div>\
            <!--row-->');
    }
    //===fetch value against hotel brn
    $(document).on("change","#hotelBrn",function () {
        var hotelID=$(this).find('option:selected').attr('val-hotel');
        var purchase_rate=$(this).find('option:selected').attr('purchase-rate');
        var qty=$(this).find('option:selected').attr('qty');
        $(this).closest('tr').find('.hotel').val(hotelID);
        $(this).closest('tr').find('.price').val(purchase_rate);
        $(this).closest('tr').find('.qty').val(qty);
        $(this).closest('tr').find('.total').val(qty*purchase_rate);
        var sum=0;
        $(".total").each(function () {
            sum +=Number($(this).val());
        });
        $(".total_amount").val(sum);
    });
    $(document).on("change","#trnsportBrn",function () {
        var company=$(this).find('option:selected').attr('trans-comp');
        var purchase_rate=$(this).find('option:selected').attr('purchase-rate');
        var qty=$(this).find('option:selected').attr('qty');
        $(this).closest('tr').find('.transport').val(company);
        $(this).closest('tr').find('.price').val(purchase_rate);
        $(this).closest('tr').find('.qty').val(qty);
        $(this).closest('tr').find('.total').val(qty*purchase_rate);
        var sum=0;
        $(".total").each(function () {
            sum +=Number($(this).val());
        });
        $(".total_amount").val(sum);
    });
    //ground services
    $(document).on("change","#otherServices",function () {
        var purchase_rate=$(this).find('option:selected').attr('purchase-rate');
        $(this).closest('tr').find('.price').val(purchase_rate);
    });
    //open visitor list modal
    function open_visitor_list(type,g) {
        $("#visitor-list-modal").modal();
        var GID=$("#ground-service-details-modal").find(".GID").val();
        $("#visitor-list-modal").find(".selected-type").val(type);
        var service=$(g).closest('.row').find('.service').val();
        $("#visitor-list-modal").find(".selected-service").val(service);
        $.ajax({
            url:"{{ url('umrah/get_visitor_data') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:{'GID':GID},
            success:function (data) {
                htmlData='';
                for(i in data){
                    htmlData+='<tr id="'+data[i].id+'">';
                    htmlData+='<td><input type="checkbox" class="select-mutamer" pax-type="'+data[i].pax_type+'" value="'+data[i].id+'" pax-list="'+data[i].pax_name+'"> '+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data[i].pax_name+'</td>';
                    htmlData+='<td>'+(data[i].gender==1?'Male':'Female')+'</td>';
                    htmlData+='<td>'+(data[i].pax_type==1?'Adult':'')+' '+(data[i].pax_type==2?'Child':'')+' '+(data[i].pax_type==3?'Infant':'')+'</td>';
                    htmlData+='<td>'+data[i].country.name+'</td>';
                    htmlData+='<td>'+data[i].passport+'</td>';
                    htmlData += '<td>';
                    htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_pax(\'' + data[i].id + '\')"><i class="fa fa-edit"></i> </a>';
                    htmlData += ' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\'' + data[i].id + '\', \'{{ url('crm/save_umrah_pax/remove') }}/' + data[i].passport + '\')"><i class="fa fa-trash"></i> </a>';
                    htmlData += '</td>';
                    htmlData+='</tr>';
                }
                $("#select_visitor_data").html(htmlData);
            }
        })
    }
    //when user click on select mutamer then will added accordingly
    $("#selected-mutamer").on("click",function () {
        var vls='';
        var sum=0;
        var adlt=0;
        var chld=0;
        var infnt=0;
        var type=$(this).closest('.modal').find('.selected-type').val();
        var pax_list='';
        var service=$(this).closest('.modal').find('.selected-service').val();
        $(this).closest('.modal-body').find('.select-mutamer:checked').each(function (e) {
            vls+=$(this).val()+',';
            if($(this).attr('pax-type')==1) {
                adlt+=Number($(this).attr('pax-type'));
            }if($(this).attr('pax-type')==2) {
                chld+=Number($(this).attr('pax-type'));
            }if($(this).attr('pax-type')==3) {
                infnt+=Number($(this).attr('pax-type'));
            }
            pax_list+=$(this).attr('pax-list')+',';
        });
        if(type==0){
            $("#ground-det-form input[name~='insured_person']").val(vls);
            $("#ground-det-form input[name~='insured_adult']").val(adlt);
            $("#ground-det-form input[name~='insured_child']").val(chld);
            $("#ground-det-form input[name~='insured_infant']").val(infnt);
            $("#ground-det-form .insurance_linked_pax").val(pax_list);
        }else{
            $(".service").find("option:selected").each(function () {
                if($(this).val()==service){
                    $(this).closest('.row').find('.got_services_by').val(vls);
                    $(this).closest('.row').find('.aadult_qty').val(adlt);
                    $(this).closest('.row').find('.achild_qty').val(chld);
                    $(this).closest('.row').find('.ainfant_qty').val(infnt);
                    $(this).closest('.row').find('.service_linked_pax').val(pax_list);

                }
            })
        }
        $("#visitor-list-modal").modal('hide');

    });
    //=============================================For adding new hotel========
    // add new hotel
    function add_new_hotel(g) {
        if($(g).val()=='new') {
            $(".new-hotel").modal();
            $(".new-hotel").find('form').attr('id', 'hotel-form');
            $(".new-hotel").find('.btn-success').removeAttr('onclick').attr('onclick', 'save_hotel()');
        }
    }
    function save_hotel() {
        $("#loader").show();
        $.ajax({
            url:"{{ route('hotel.store') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#hotel-form").serialize(),
            success:function (data) {
                toastr.success('Operation Successfully..');
                document.getElementById("form").reset();
                $(".new-hotel").modal('hide');
                $("#hotel-reservation-form select[name~='hotel_id']").append('<option selected value="'+data.id+'">'+data.name+'</option>');
                $("#loader").hide();
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#hotel-form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    }
    //============Add New Cities===
    function add_new_city(g) {
        if($(g).val()=='new') {
            $(".new-city").modal();
            $(".new-city").find('form').attr('id', 'city-form');
            $(".new-city").find('.btn-success').removeAttr('onclick').attr('onclick', 'save_city()');
        }
    }
    function save_city() {
        $.ajax({
            url:"{{ route('cities.store') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#city-form").serialize(),
            success:function (data) {
                toastr.success('Operation Successfully..');
                $(".new-city").modal('hide');
                $("#hotel-reservation-form select[name~='city_id']").append('<option selected value="'+data.id+'">'+data.name+'</option>');
                $("#loader").hide();
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#city-form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
            }
        })
    }
    //===========================External Agent===
    function add_external_agent(g) {
        if($(g).val()=='new') {
            $("#external-agent").modal();
        }
    }
    //excel modal
    function import_excel_group() {
        $("#excel-modal").modal();
    }
    //save excel file
    $('#excel-form').submit(function (e) {
        $("#loader").show();
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ url('umrah/save_group_excel') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            dataType: "JSON",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                toastr.success('Operation Successfully..');
                $("#pax-modal").modal('hide');
                $("#loader").hide();
                get_data(1);
            }, error: function (ajaxcontent) {
                vali = ajaxcontent.responseJSON.errors;
                var errors = '';
                $.each(vali, function (index, value) {
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    });
    //============calculation==========
    function total_amount(g) {
        var adlt_rate=$(".adult_rate").val();
        var chld_rate=$(".child_rate").val();
        var infnt_rate=$(".infant_rate").val();
        var adlt_qty=$(".adult_qty").val();
        var chld_qty=$(".child_qty").val();
        var infnt_qty=$(".infant_qty").val();
        var total_adult=Number(adlt_rate)*Number(adlt_qty);
        var total_chld=Number(chld_rate)*Number(chld_qty);
        var total_infnt=Number(infnt_rate)*Number(chld_qty);
        var total=Number(total_adult)+Number(total_chld)+Number(total_infnt);
        $(".total").val(total);
        grand_total();

    }
    //calculate insureance
    function total_ins_amount() {
        var adlt_rate=$(".insurance_adult_rate").val();
        var chld_rate=$(".insurance_child_rate").val();
        var infnt_rate=$(".insurance_infant_rate").val();
        var adlt_qty=$(".insured_adult").val();
        var chld_qty=$(".insured_child").val();
        var infnt_qty=$(".insured_infant").val();
        var total_adult=Number(adlt_rate)*Number(adlt_qty);
        var total_chld=Number(chld_rate)*Number(chld_qty);
        var total_infnt=Number(infnt_rate)*Number(chld_qty);
        var total=Number(total_adult)+Number(total_chld)+Number(total_infnt);
        $(".total_insurance").val(total);
        grand_total();
    }
    $(document).on("keyup",".add_service_cal",function () {
        var adlt_rate=$(this).find(".aadult_rate").val();
        var chld_rate=$(this).find(".achild_rate").val();
        var infnt_rate=$(this).find(".ainfant_rate").val();
        var adlt_qty=$(this).find(".aadult_qty").val();
        var chld_qty=$(this).find(".achild_qty").val();
        var infnt_qty=$(this).find(".ainfant_qty").val();
        var total_adult=Number(adlt_rate)*Number(adlt_qty);
        var total_chld=Number(chld_rate)*Number(chld_qty);
        var total_infnt=Number(infnt_rate)*Number(chld_qty);
        var total=Number(total_adult)+Number(total_chld)+Number(total_infnt);
        $(this).find(".total_service_amount").val(total);
        grand_total();
    });
    //grand total
    function grand_total() {
        var total_amount=$(".total").val();
        var total_ins_amount=$(".total_insurance").val();
        var sum=0;
        $(".total_service_amount").each(function () {
            sum+=Number($(this).val());
        });
        var grand_total=Number(total_amount)+Number(total_ins_amount)+Number(sum);
        $(".grand_total").val(grand_total);
    }
    //==============================for adding new agent=======
    function add_new_agent(g) {
        if($(g).val()=='new') {
            $(".agent-modal").modal();
            $(".agent-modal input[name~='id']").val(0);
            $(".agent-modal").find('.btn-success').removeAttr('onclick').attr('onClick','save_agent()');
            $(".agent-modal").find('form').removeAttr("id").attr("id","agent-form");
        }
    }
    function save_agent() {
        $("#loader").show();
        $.ajax({
            url:"{{ route('subadmin.store') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#agent-form").serializeArray(),
            success:function (data) {
                $("#agent-form input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById("agent-form").reset();
                $(".agent-modal").modal('hide');
                $("#form select[name~='agentID']").append('<option selected value="'+data.id+'">'+data.agent_name+'</option>');
                $("#loader").hide();
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#agent-form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    }
    //upload visitor files in excel
    $('#upload-visitor').submit(function (e) {
        $("#loader").show();
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ url('umrah/save_visitor_excel') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            dataType: "JSON",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                toastr.success('Operation Successfully..');
                get_data(1);
                var GIB=$("#visitor-form input[name~='group_id']").val();
                $("#loader").hide();
                get_visitor_data(GIB);
            }, error: function (ajaxcontent) {
                vali = ajaxcontent.responseJSON.errors;
                var errors = '';
                $.each(vali, function (index, value) {
                    toastr.error(value);
                });
                $("#loader").hide();
            }
        })
    });
    //upload bulk mutamers
    function bulk_mutamer() {
        $("#pax-modal").modal();
        $("#visitor-form").hide();
    }
    //fetch transport  Available capacity
    function available_capacity(g) {
        brn=$(g).val();
        $.ajax({
            url: "{{ url('umrah/fetch_available_capacity') }}/"+brn,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $(g).closest('.row').find('.available').val(data.available);
            }
        })
    }
    //availability validation
    function enter_pax(g) {
        var available=$(g).closest('.row').find('.available').val();
        var enter_pax=$(g).closest('.row').find('.no_pax').val();
        if(Number(enter_pax) > Number(available)){
            toastr.error('No of Pax should not be more than Available Capacity');
            setTimeout(function (args) {
                $(g).closest('.row').find('.no_pax').val('');
            },1000);
        }
    }
    //check hotel available capacity
    function available_hotel_capacity(g) {
        brn=$(g).val();
        $.ajax({
            url: "{{ url('umrah/fetchHotel_available_capacity') }}/"+brn,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $(g).closest('.row').find('.available').val(data.available);
                $(g).closest('.row').find('.room_type').val(data.total_capacity.room_type);
                $(g).closest('.row').find('.no_room').val(data.total_capacity.no_room);
                $(g).closest('.row').find('.no_beds').val(data.available);
            }
        });
    }
    function del_visitor(id, route) {
        var x = confirm('Are you Sure?');
        if (!x) {
            return false;
        }
        $.ajax({
            url: route,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $("#vis_" + id).hide();
            },
        })
    }
</script>