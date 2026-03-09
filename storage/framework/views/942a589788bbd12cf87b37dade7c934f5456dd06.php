<script>
    //search options of transport additional price
    function search_transport_option(g) {
        $("#search-transport-option").modal();
        var tr_id=$(g).closest('.row').find('.index_value').val();//transport row id
        $("#search-transport-option").find('.tr-row').val(tr_id);
        var from_city=$(g).closest('.row').find('.from_city ').val();
        var to_city=$(g).closest('.row').find('.to_city ').val();
        var no_of_pax=$(g).closest('.row').find('.no_of_pax ').val();
        $.ajax({
            url:"<?php echo e(url('agent_management/search_transport_availability')); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            data:{'form_city':from_city, 'to_city':to_city,'no_of_pax':no_of_pax},
            success:function (data) {
                $("#select-sectors").html(data.htmlData);
            }
        });
    }
    //open transport seat modal
    function open_transport_seat(g, brn) {
        $("#select-transport-seats").modal();
        $("#select-transport-seats").find('.brn').val(brn);
        var total_seats=$(g).val();
        var seatHtml='';
        for(i=0; i<total_seats; i++){
            seatHtml+='' +
                '<div class="col-md-3">\
                    <div class="form-group">\
                    <div class="custom-control custom-checkbox">\
                    <input class="custom-control-input select_transport_seat" value="1" type="checkbox" id="customCheckbox'+i+'" value="option1">\
                    <label for="customCheckbox'+i+'" class="custom-control-label">Select Seat</label>\
                </div>\
                </div>\
                </div>';
        }
        $("#transport-available-seat").html(seatHtml);
    }
    //select transport seat after checked checkboxes
    function select_transport_seat() {
        var sum=0;
        var brn=$("#select-transport-seats").find('.brn').val();brn
        $(".select_transport_seat:checked").each(function (index, value) {
            sum +=Number($(this).val());
        });
        $("#sector-"+brn).find('.selected_pax').val(sum);
        var from_city=$("#sector-"+brn).find('.from_city').val();
        var to_city=$("#sector-"+brn).find('.to_city').val();
        var trans_type=7;
        var transport_date=$("#sector-"+brn).find('.sector_date').val();
        $.ajax({
            url: "<?php echo e(url('agent_management/fetch_transport_rate')); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            data: {'from_city': from_city, 'to_city': to_city, 'trans_type': trans_type,'transport_date':transport_date},
            success: function (data) {
                if (data.agent_price[0] == 2) {
                    var markup = data.agent_price[1];
                }
                $("#sector-"+brn).find('.selected_pax_rate').val((Number(data.res_rate) + Number(markup)) * Number(data.res.currency_rate));
                $("#sector-"+brn).find('.transport_cost').val(Number(data.res_rate) * Number(data.res.currency_rate));
                $("#sector-"+brn).find('.TRID').val(data.res.id);
            }
        });
        $("#select-transport-seats").modal('hide');
    }
    //Assign Transport sectors
    $(document).on("click",".assign_sector",function () {
        var tr_id=$("#search-transport-option").find('.tr-row').val();
        $(".select-checkbox:checked").each(function () {
            sec_date=$(this).closest('.row').find('.sector_date').val();
            sec_time=$(this).closest('.row').find('.sector_time').val();
            no_pax=$(this).closest('.row').find('.selected_pax').val();
            rate=$(this).closest('.row').find('.selected_pax_rate').val();
            cost=$(this).closest('.row').find('.transport_cost').val();
            TRID=$(this).closest('.row').find('.TRID').val();
            $("#trans-"+tr_id).find('.transport_rate').val(rate);
            $("#trans-"+tr_id).find('.transport_net').val(Number(no_pax)*Number(rate));
            $("#trans-"+tr_id).find('.date').val(sec_date);
            $("#trans-"+tr_id).find('.time').val(sec_time);
            $("#trans-"+tr_id).find('.no_of_pax').val(no_pax);
            $("#trans-"+tr_id).find('.transport_cost').val(cost);
            $("#trans-"+tr_id).find('.TRID').val(TRID);
            $("#search-transport-option").modal('hide');
            sum_transports();
        })
    });
    //===========================Hotel options
    function search_hotel_option(g) {
        $("#search-hotel-option").modal();
        var tr_id=$(g).closest('.row').find('.index_value').val();//transport row id
        $("#search-hotel-option").find('.tr-row').val(tr_id);
        var city_id=$(g).closest('.row').find('.city_id').val();//city id
        var rt=$(g).closest('.row').find('.room_type').val();//room type
        var checkin=$(g).closest('.row').find('.checkin').val();//room type
        $.ajax({
            url:"<?php echo e(url('crm/umrah_agent_booking/search_hotel_availability')); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            data:{'city_id':city_id,'room_type':rt,'checkin':checkin},
            success:function (data) {
                $("#select-beds").html(data.htmlData);
                $(".select2").select2();
            }
        });
    }
    //open Hotel room modal
    function open_hotel_room(g, brn) {
        $("#select-hotel-room").modal();
        $("#select-hotel-room").find('.brn').val(brn);
        var total_seats=$(g).val();
        var seatHtml='';
        for(i=0; i<total_seats; i++){
            seatHtml+='' +
                '<div class="col-md-3">\
                    <div class="form-group">\
                    <div class="custom-control custom-checkbox">\
                    <input class="custom-control-input select_hotel_room" value="1" type="checkbox" id="customCheckbox'+i+'" value="option1">\
                    <label for="customCheckbox'+i+'" class="custom-control-label">Select Room</label>\
                </div>\
                </div>\
                </div>';
        }
        $("#hotel-available-room").html(seatHtml);
    }
    //select transport seat after checked checkboxes
    function select_hotel_room() {
        var sum=0;
        var brn=$("#select-hotel-room").find('.brn').val();
        $(".select_hotel_room:checked").each(function (index, value) {
            sum +=Number($(this).val());
        });
        $("#room-"+brn).find('.selected_room').val(sum);
        var room_type=$("#room-"+brn).find('.room_type').val();
        var hotel_id=$("#room-"+brn).find('.hotel_id').val();
        var checkin=$("#room-"+brn).find('.checkin').val();
        var checkout=$("#room-"+brn).find('.checkout').val();
        $.ajax({
            url: "<?php echo e(url('crm/fetch_hotel_rate')); ?>",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            data: {'hID': hotel_id, 'checkin': checkin, 'checkout': checkout,'type':room_type},
            success: function (data) {
                if (data.agent_price.markup_type == 2) {
                    var markup = data.agent_price.markup_value;
                }
                $("#room-"+brn).find('.hotel_rate').val((Number(data.res_rate) + Number(markup)) * Number(data.currency_rate));
                $("#room-"+brn).find('.hotel_cost').val(Number(data.res_rate) * Number(data.currency_rate));
                $("#room-"+brn).find('.HRID').val(data.agent_price.HRID);
            }
        });
        $("#select-hotel-room").modal('hide');
        $(".select2").select2();
    }
    //Assign Hotel Room & Beds
    $(document).on("click",".assign_hotel",function () {
        var tr_id=$("#search-hotel-option").find('.tr-row').val();
        $("#search-hotel-option .select-checkbox:checked").each(function () {
            hotel_id=$(this).closest('.row').find('.hotel_id').val();
            rt=$(this).closest('.row').find('.room_type').val();
            rm=$(this).closest('.row').find('.selected_room').val();
            no_pax=$(this).closest('.row').find('.selected_pax').val();
            checkin=$(this).closest('.row').find('.checkin').val();
            checkout=$(this).closest('.row').find('.checkout').val();
            nights=$(this).closest('.row').find('.nights').val();
            rate=$(this).closest('.row').find('.hotel_rate').val();
            city=$(this).closest('.row').find('.city_id').val();
            hotel_cost=$(this).closest('.row').find('.hotel_cost').val();
            HRID=$(this).closest('.row').find('.HRID').val();
            $("#hotel-"+tr_id).find('.hotel ').val(hotel_id);
            $("#hotel-"+tr_id).find('.room_type').val(rt);
            $("#hotel-"+tr_id).find('.room').val(rm);
            $("#hotel-"+tr_id).find('.no_pax').val(no_pax);
            $("#hotel-"+tr_id).find('.checkin').val(checkin);
            $("#hotel-"+tr_id).find('.checkout').val(checkout);
            $("#hotel-"+tr_id).find('.nights').val(nights);
            $("#hotel-"+tr_id).find('.hotel_rate').val(rate);
            if(rt==7){
                $("#hotel-"+tr_id).find('.hotel_net').val(rate*no_pax);
            }else{
                $("#hotel-"+tr_id).find('.hotel_net').val(rate*rm);
            }
            $("#hotel-"+tr_id).find('.city_id').val(city);
            $("#hotel-"+tr_id).find('.hotel_cost').val(hotel_cost);
            $("#hotel-"+tr_id).find('.HRID').val(HRID);
            sum_hotels();
            $("#search-hotel-option").modal('hide');
            $(".select2").select2();
        })
    });
</script><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/agents/agent_booking/search-option-js.blade.php ENDPATH**/ ?>