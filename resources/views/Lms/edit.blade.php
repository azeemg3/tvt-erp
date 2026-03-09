@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">LMS</li>
                            <li class="breadcrumb-item active">Create Lead</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="form">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Contact Name:</label>
                                            <input placeholder="Contact Name" class="form-control form-control-sm" name="contact_name" type="text" value="{{ $data->contact_name }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Mobile:</label>
                                            <input placeholder="e.g 923244659501" class="form-control form-control-sm" name="mobile" type="text">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" class="form-control form-control-sm" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>CNIC:</label>
                                            <input placeholder="CNIC" class="form-control form-control-sm" name="cnic">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>SPO:</label>
                                            <select class="form-control form-control-sm select2" name="spo">
                                                <option value="">Select Spo</option>
                                                {!! App\Models\User::dropdown() !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Traveling Date From:</label>
                                            <input type="text" class="form-control form-control-sm date" name="travel_date_from" placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Traveling Date To:</label>
                                            <input type="text" class="form-control form-control-sm date" name="travel_date_to" placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <label>Country:</label>
                                            <select class="form-control form-control-sm select2 country" data-placeholder="Select Country" name="CID">
                                                <option value="">Select Country</option>
                                                {!! App\Models\Country::dropdown() !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <label>City:</label>
                                            <select class="form-control form-control-sm select2 city" data-placeholder="Select City" name="CTID">
                                                <option value="">Select City</option>
                                                {!! App\Models\City::dropdown() !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>Services</label>
                                            <select class="form-control form-control-sm select2" multiple data-placeholder="Select Services" name="services[]">
                                                <option value="">Select Services</option>
                                                {!! App\Helpers\CommonHelper::services() !!}
                                            </select>
                                        </div>
                                    </div>
                                    <!--end-column-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Sector:</label>
                                            <input type="text" class="form-control form-control-sm" name="" placeholder="e.g. LHE-KHE" name="sector">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <label>Source Of Query</label>
                                            <select class="form-control form-control-sm" name="source_of_query">
                                                {!! App\Helpers\CommonHelper::query_source() !!}
                                            </select>
                                        </div>
                                    </div>
                                    <!--end-column-->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <textarea rows="20" class="form-control textarea" placeholder="Other Details" name="other_details"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-12 float-right">
                                        <button class="btn btn-success btn-flat float-right"  type="button" onclick="save_rec(1)">Create & Takeover</button>
                                        <button class="btn btn-primary btn-flat float-right"  type="button" onclick="save_rec(2)">Create for Others</button>
                                    </div>
                                    <!--end-column-->
                                </div>
                                <!--end-row-->
                            </form>
                        </div>
                        <!-- /.card-body -->
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
            $('.textarea').summernote()
        });
        function save_rec(type) {
            $("#loader").show();
            var formData=$()
            $.ajax({
                url:"{{ route('lead.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serialize()+"&save="+type,
                success:function (data) {
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#loader").hide();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                        $("#loader").hide();
                    });
                }
            })
        }
    </script>
@endsection<!-- jQuery -->