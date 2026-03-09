<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    get_lead_conversation();
    function get_lead_conversation() {
        $.ajax({
            url:"{{ url('lms/get_lead_conversation') }}/{{ $result[0]->id }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"JSON",
            success:function (data) {
                var htmlData='';
                for(i in data){
                    htmlData+='<div class="direct-chat-text">' +
                        '<span class="direct-chat-timestamp float-right">'+date_time_ra(data[i].created_at)+'</span>'+
                    ''+data[i].comment+'</div>';
                }
                $(".lead-chat").html(htmlData);

            }
        })
    }
    function lead_conversation(ob) {
        g=ob;
        $(ob).text('sending..').attr('disabled', 'disabled');
        $.ajax({
            url:"{{ url('lms/lead_conversation') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            data:$("#lead-conv-form").serialize(),
            success:function (data) {
                //toastr.success('Operation Successfully..');
                document.getElementById("lead-conv-form").reset();
                $(ob).text('Send').removeAttr('disabled');
                $(".lead-chat").append('<div class="direct-chat-text">' +
                    '<span class="direct-chat-timestamp float-right">'+date_time_ra(data.created_at)+'</span>' +
                    ''+data.comment+'</div>');

            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#lead-conv-form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
            }
        })
    }
    //fetch lead details
    function get_lead_details() {
        $("#ledger-modal").modal();
        $.ajax({
            url:"{{ url('lms/get_lead_details/') }}/{{ $result[0]->id }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"JSON",
            success:function (data) {
                $("#ledger-form input[name~='Trans_Acc_Name']").val(data.contact_name);
            }
        });
    }
    //create account leadger
    function creae_ledger() {
        $.ajax({
            url:"{{ url('lms/lead_ledger/') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"JSON",
            type:"POST",
            data:$("#ledger-form").serialize(),
            success:function (data) {
                $("#ledger-form input[name~='Trans_Acc_Name']").val(data.contact_name);
                toastr.success('Operation Successfully..');
                window.location.href='';
            },error:function(ajaxcontent) {
                vali=ajaxcontent.responseJSON.errors;
                var errors='';
                $.each(vali, function( index, value ) {
                    $("#ledger-form input[name~='" + index + "']").css('border', '1px solid red');
                    toastr.error(value);
                });
            }
        });
    }
</script>