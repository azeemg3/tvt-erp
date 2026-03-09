<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        $('#reservation').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('#reservation').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
        });
    });
    function more_transport(g) {
        $('.more-transport').append('<div class="row">\
                    <div class="col-md-2">\
                        <div class="form-group">\
                        <select class="form-control form-control-sm select2" name="v_purchased_by[]">\
                            <option value="">Select Vendor</option>\
                            {!! App\Models\Accounts\TransactionAccount::vendor_dd() !!}\
                     </select>\
                    </div>\
                </div>\
                <!--col-->\
                <div class="col-md-2">\
            <div class="form-group">\
        <select name="transport_city[]" class="form-control form-control-sm select2">\
            <option value="0">Select City</option>\
            {!! App\Models\City::dropdown() !!}\
        </select>\
    </div>\
    </div>\
        <!--col-->\
            <div class="col-md-2">\
                <div class="form-group">\
                <select name="transport[]" class="form-control form-control-sm select2 vehicle_type">\
                <option value="">Select Transport</option>\
                {!! App\Helpers\CommonHelper::vehicle_types() !!}\
            </select>\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-3">\
                <div class="form-group">\
                <input type="text" name="sector[]" class="form-control form-control-sm" placeholder="LHE-JED">\
                </div>\
                </div>\
                <!--col-->\
                <div class="col-md-2">\
                <div class="form-group">\
                <input type="number" name="transport_rate[]" onkeyup="start_pkg_price()" class="form-control form-control-sm transport_rate" placeholder="Rate">\
                </div>\
                </div>\
                <!--col-->\
                <div class="col-md-1">\
                <div class="form-group">\
            <button class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i> </button>\
                </div>\
                </div>\
                <!--col-->\
                </div>\
                <!--row-->');
        $(".select2").select2();
    }
    //more hotels
    function more_hotel(g) {
        $(".more-hotel").append('<div class="row">\
                <div class="col-md-2">\
                <div class="form-group">\
                <select class="form-control form-control-sm select2" name="t_purchased_by">\
                <option value="">Select Vendor</option>\
                {!! App\Models\Accounts\TransactionAccount::vendor_dd() !!}\
                </select>\
                </div>\
                </div>\
                <div class="col-md-2">\
                <div class="form-group">\
                <select name="transport_city[]" class="form-control form-control-sm select2">\
                    <option value="0">Select City</option>\
                    {!! App\Models\City::dropdown() !!}\
                </select>\
            </div>\
            </div>\
                <!--col-->\
            <div class="col-md-2">\
                <div class="form-group">\
                <select name="hotel_name[]" class="form-control form-control-sm select2">\
                    <option value="0">Select Hotel</option>\
                {!! App\Models\Hotel::dropdown() !!}\
                </select>\
                    </select>\
                    </div>\
                    </div>\
                    <!--col-->\
            <div class="col-md-2">\
                <div class="form-group">\
                <select name="category[]" class="form-control form-control-sm select2">\
                    <option value="">Select Category</option>\
                <option value="">Economy</option>\
                    <option value="">3 Star</option>\
                <option value="">4 Star</option>\
                </select>\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-2">\
                <div class="form-group">\
            <select name="room_type[]" class="form-control form-control-sm room_type">\
                <option value="">Select Room</option>\
            {!! App\Models\RoomType::dropdown() !!}\
            </select>\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-1">\
                <div class="form-group">\
            <input type="number" name="room_rate[]" onkeyup="start_pkg_price()" class="form-control form-control-sm hotel_rate" placeholder="Rate Per Night">\
                </div>\
                </div>\
                <!--col-->\
                <div class="col-md-1">\
                <div class="form-group">\
                <button type"button" class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i> </button>\
                </div>\
                </div>\
                <!--col-->\
                </div>\
                <!--row-->');
        $(".select2").select2();
    }
    $(document).on("click",".remove", function () {
        $(this).closest('.row').remove();
        start_pkg_price();
    });
    function more_info() {
        $(".more-info").append('<div class="row">\
            <div class="col-xs-12 col-md-10">\
            <div class="form-group">\
            <label>Title</label>\
            <input type="text" name="title[]" class="form-control form-control-sm" placeholder="Enter...">\
            </div>\
            </div>\
            <!--col-->\
            <div class="col-md-2">\
            <button type="button" class="btn btn-info btn-sm" onclick="more_info()" style="margin-top: 20px;"><i class="fa fa-plus"></i></button>\
            <button type="button" class="btn btn-danger btn-sm remove" style="margin-top: 20px;"><i class="fa fa-trash"></i></button>\
            </div>\
            <div class="col-xs-12 col-sm-12 col-md-12">\
            <div class="form-group">\
            <label>Details</label>\
            <textarea name="info_detail[]" class="textarea" placeholder="Place some text here"\
        style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>\
            </div>\
            </div>\
            <!--col-->\
            </div>\
            <!--row-->');
        $('.textarea').summernote();
    }
    //calculate staring price of tour packages
    function start_pkg_price(){
       let visa_pric=$(".visa_price").val();
       let mrkup=$(".markup").val();
       let ground_ser=$(".gs").val();
       var tp=0;
       var ht=0;
       $(".transport_rate").each(function (){
           if($(this).closest('.row').find('.vehicle_type').val()==7) {
               tp = $(this).val();
           }
       });
       $(".hotel_rate").each(function (){
           if($(this).closest('.row').find('.room_type').val()==4) {
               ht = $(this).val();
           }
       });
       t_pkg=Number(visa_pric)+Number(tp)+Number(ht)+Number(mrkup)+Number(ground_ser);
       $("#pkg_price").val(t_pkg);
    }
</script>
