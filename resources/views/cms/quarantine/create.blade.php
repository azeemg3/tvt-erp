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
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item">Quarantine</li>
                            <li class="breadcrumb-item active">Create New</li>
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
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="fa fa-exclamation"></i> {{ $error }}
                                </div>
                            @endforeach
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <i class="fa fa-check"></i> {{session('success')}}</div>
                            @endif
                            <form action="{{ route('quarantine.store') }}" method="post" enctype="multipart/form-data">
                                @CSRF
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Package Name*</label>
                                            <input name="pkg_name" type="text" class="form-control form-control-sm" placeholder="Enter Destination..." value="{{ old('pkg_name') }}">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Country*</label>
                                            <select class="form-control form-control-sm select2 country" name="country_id">
                                                {!! App\Models\Country::dropdown(old('country_id')) !!}
                                            </select>
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>City*</label>
                                            <select class="form-control form-control-sm select2 city" name="city_id">
                                                {!! App\Models\City::dropdown(old('city_id')) !!}
                                            </select>
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Airlines</label>
                                            <select name="airline_id" class="form-control form-control-sm select2">
                                                <option value="">Select Airline</option>
                                                {!! App\Models\Airline::dropdown(old('airline_id')) !!}
                                            </select>
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Guest Price</label>
                                            <input name="guest_price" type="text" class="form-control form-control-sm" placeholder="Enter Price">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Inclusions</label>
                                            <select name="inclusions[]" class="form-control form-control-sm select2" multiple>
                                                {!! App\Helpers\cms::incluions() !!}
                                            </select>
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Package Details</label>
                                            <textarea name="pkg_details" class="textarea" placeholder="Place some text here"
                                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Quarantine Information</label>
                                            <textarea name="quarantine_information" class="textarea" placeholder="Place some text here"
                                                      style="width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                                        </div>
                                    </div>
                                    <!--col-->
                                </div>
                                <!--end-row-->
                                <h3>Hotel Information:</h3>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Hotel Name</label>
                                            <input type="text" name="hotel_name" class="form-control form-control-sm" placeholder="Enter...">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Checkin Date</label>
                                            <input type="datetime" name="checkin_date" class="date form-control form-control-sm" placeholder="Enter...">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Checkin Time</label>
                                            <input type="time" name="checkin_time" class="form-control form-control-sm" placeholder="Enter...">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Checkout Date</label>
                                            <input type="datetime" name="checkout_date" class="date form-control form-control-sm" placeholder="Enter...">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Checkout Time</label>
                                            <input type="time" name="checkout_time" class="form-control form-control-sm" placeholder="Enter...">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Hotel Star</label>
                                            <select name="hotel_star" class="form-control form-control-sm select2">
                                                <option value="">Select Star</option>
                                                <option value="">One Star</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Hotel Images</label>
                                            <input type="file" name="hotel_images[]" class="form-control form-control-sm" placeholder="Enter..." multiple>
                                        </div>
                                    </div>
                                    <!--col-->
                                </div>
                                <!--end-row-->
                                <h3>Transports:</h3>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Transport Type</label>
                                            <select name="transport_type" class="form-control form-control-sm select2">
                                                <option value="">Select Type</option>
                                                {{--{!! App\Helpers\CommonHelper::vehicle_types() !!}--}}
                                                <option value="1">Car</option>
                                                <option value="2">Bus</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Transport City</label>
                                            <select name="transport_city" class="form-control form-control-sm select2 city">
                                                <option value="">Select City</option>
                                                {!! App\Models\City::dropdown() !!}
                                            </select>
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Transport Date</label>
                                            <input type="datetime" name="transport_date" class="date form-control form-control-sm" placeholder="Enter...">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Transport Images</label>
                                            <input type="file" name="transport_image" class="form-control form-control-sm" placeholder="Enter..." multiple>
                                        </div>
                                    </div>
                                    <!--col-->
                                </div>
                                <!--end-row-->
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">

                                        <button type="submit" class="btn btn-sm btn-success btn-flat float-right">Submit</button>

                                    </div>
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
        });
    </script>
@endsection<!-- jQuery -->