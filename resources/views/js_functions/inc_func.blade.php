<script>
    //fethc city by select country
    $(document).on("change",".country", function () {
        var country=$(this).val();
        $.ajax({
            url:"{{ url('cities') }}/"+country,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                 for(i in data){
                     htmlData+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                 }
                 $(".city").html(htmlData);
            }
        });
    });
</script>