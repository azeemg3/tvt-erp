// JavaScript Document
$(document).ready(function(){
  $("input, select").focusin(function(){
    $(this).css("background-color", "black");
	$(this).css("color", "white");
  });
  $("input, select").focusout(function(){
    $(this).css("background-color", "#FFFFFF");
	 $(this).css("color", "black");
  });
});
$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
  $(this).closest(".select2-container").siblings('select:enabled').select2('open');
	//$(this).css("background-color", "red");
});

function pagination(total_rec, per_page, cur_page, to, func, paginateClass, id) {
    var arr;
    if(paginateClass!=undefined) {
        arr = paginateClass.split('-');
        arr = arr.slice(-1).pop();
    }
    var total = total_rec;
    get_data = func;
    no_ofPage = Math.ceil(total / per_page);
    if (cur_page >= 5) {
        start_loop = cur_page - 3;
        end_loop = Number(cur_page) + Number(2);
        if (no_ofPage - 1 == cur_page) {
            end_loop = no_ofPage;
        }
        if (cur_page == no_ofPage) {
            end_loop = no_ofPage;
        }
    } else {
        start_loop = 1;
        if (no_ofPage > 5)
            end_loop = 5;
        else
            end_loop = no_ofPage;
    }
    var htmlData = '';
    htmlData += '<ul class="pagination pagination-sm m-0 float-right">' +
        '<li class="page-item">' +
        '<a class="page-link" onclick="get_data(1)" aria-label="Previous"><span aria-hidden="true">«</span></a>' +
        '</li>';
    for (i = start_loop; i <= end_loop; i++) {
        if (i == cur_page) {
            htmlData += '<li class="page-item active"><a class="page-link" onclick="get_data(' + i + ', \''+id+'\')">' + i + '</a></li>';
        } else {
            htmlData += '<li class="page-item"><a class="page-link" onclick="get_data(' + i + ', \''+id+'\')">' + i + '</a></li>';
        }
    }
    htmlData += '<li class="page-item">' +
        '<a class="page-link" onclick="get_data(' + no_ofPage + ')" aria-label="Next">' +
        '<span aria-hidden="true">»</span>' +
        '</a>' +
        '</li>' +
        '</ul>';
    if(arr==undefined){
        $(".pagination-panel").html(htmlData);
    }else{
        $("."+paginateClass).html(htmlData);
    }

}
function del_rec(id, route) {
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
            $("#" + id).hide();
        },
    })
}
function null_val(vl)
{
	if(vl==null)
	{
		return 'N/A';
	}
	else
	{
		return vl;
	}
}
//number format 
function number_format(num)
{
    if(num=='null'){
        return Number(0.00);
    }else{
	   var numb=Number(num).toLocaleString('en-US', {minimumFractionDigits: 2});
	   return numb;
    }
}
//simple format witout 00
function snf(num)
{
	return num.toLocaleString();
}
//@single date picker
$(function() {
    $('.date').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        startDate: true,
        minYear: 1930,
        maxYear: parseInt(moment().format('YYYY'),15),
        locale: {
            format: 'YYYY-MM-DD',
        },
    });
    $(".date").on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-M-DD'));
    });
    $(".date").attr("autocomplete", "off");
});
//martial status
function martial_status(status) {
    const ms =['Married','Single'];
    return (ms[status-1]);
}
//lead status badges lsb=lead status badge
function lsb(status) {
    if(status==0){
        return '<span class="badge bg-warning">pending</span>';
    }else if(status==1){
        return '<span class="badge bg-info">Takenover</span>';
    }else if(status==2){
        return '<span class="badge bg-blue">Process</span>';
    }else if(status==3){
        return '<span class="badge bg-success">Successful</span>';
    }else if(status==4){
        return '<span class="badge bg-danger">Unsuccessful</span>';
    }
}

$(document).ready(function(){
    $(".filter-toggle").click(function(){
        $(".filter-section").toggle('slow');
    });
});

//@get date time in readable format date_time_ra=date time read able format
function date_time_ra(dateFromat) {
    var date = new Date(dateFromat);
    var d = date.getDate();
    var month = date.getMonth()+1;
    var y = date.getFullYear();
    return y+'-'+month+'-'+d+' '+date.getHours()+':'+date.getMinutes()+':'+date.getHours();
}
//visa type
function visa_type(type) {
    if(type==1){
        return 'visit Visa';
    }else if(type==2){
        return 'Hajh'
    }else if(type==3){
        return 'Umrah'
    }else if(type==4){
        return 'Ziyarat'
    }else if(type==5){
        return 'Student'
    }else if(type==6){
        return 'Employment'
    }
}
function pax_type(type) {
    if(type==1){
        return 'Adult';
    }else if(type==2){
        return 'Child'
    }else if(type==3){
        return 'Infant'
    }else{
        return 'N/A';
    }
}
//vehcicle types
function vehicle_type(type) {
    if(type==1){
        return 'Coaster';
    }else if(type==2){
        return 'Gmc'
    }else if(type==3){
        return 'H1'
    }else if(type==4){
        return 'Limousine'
    }else if(type==5){
        return 'Private Car'
    }else if(type==6){
        return 'Sedan Car'
    }else if(type==7){
        return 'Sharing Bus'
    }else if(type==8){
        return 'SUV Car'
    }else if(type==9){
        return 'Haramain Train'
    }
}
function get_visa_type(type) {
    if(type==1){
        return 'Visit';
    }else if(type==2){
        return 'Hajh';
    }else if(type==3){
        return 'Umrah';
    }else if(type==4){
        return 'Ziyarat';
    }else if(type==5){
        return 'Student';
    }else if(type==6){
        return 'Employment';
    }else{
        return 'N/A';
    }
}
function room_type(type) {
    if(type==1){
        return 'Single';
    }else if(type==2){
        return 'Double';
    }else if(type==3){
        return 'Triple';
    }else if(type==4){
        return 'Quad';
    }else if(type==5){
        return 'Quint';
    }else if(type==6){
        return '6 Bed';
    }else if(type==7){
        return 'Sharing';
    }
}
//get the month name in text
function text_month(mnth) {
    if(mnth==1){
        return 'Jan';
    }else if(mnth==2){
        return 'Feb';
    }else if(mnth==3){
        return 'Mar';
    }else if(mnth==4){
        return 'April';
    }else if(mnth==5){
        return 'May';
    }else if(mnth==6){
        return 'Jun';
    }else if(mnth==7){
        return 'Jul';
    }else if(mnth==8){
        return 'Aug';
    }else if(mnth==9){
        return 'Sep';
    }else if(mnth==10){
        return 'Oct';
    }else if(mnth==11){
        return 'Nov';
    }else if(mnth==12){
        return 'Dec';
    }else{
        return 'N/A';
    }
}
//add 00 wtih 1 didgit
function sn(num) {
    if(num<10){
        return '0'+num;
    }else{
        return num;
    }
}