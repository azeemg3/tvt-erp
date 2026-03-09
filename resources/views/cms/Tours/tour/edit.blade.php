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
                            <li class="breadcrumb-item">Tours</li>
                            <li class="breadcrumb-item active">Update Tour</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <form action="{{ route('tour.update',$result->id ) }}" method="post" enctype="multipart/form-data">
                @CSRF
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <!--card-header -->
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
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-9">
                                        <div class="form-group">
                                            <label>Package Name*</label>
                                            <input name="pkg_name" type="text" class="form-control form-control-sm" placeholder="Enter Destination..." value="{{ $result->pkg_name }} {{ old('pkg_name') }}">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select name="country_id" type="text" class="country form-control form-control-sm select2">
                                                <option value="">Select Country</option>
                                                {!! App\Models\Country::dropdown($result->country_id) !!}
                                            </select>
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Duration</label>
                                            <input name="duration" value="{{ $result->duration }}{{ old('duraion') }}"  type="text" class="form-control form-control-sm" placeholder="Duration e.g total nights">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Validity</label>
                                            <input type="text" name="traveling_dt" value="{{ $result->validity_from.'/'.$result->validity_to }}{{ old('traveling_dt') }}" id="reservation" class="form-control form-control-sm" placeholder="Traveling Date From">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Departure Details</label>
                                            <input type="text" name="departure_details" value="{{ $result->departure_details }}{{ old('departure_details') }}" class="form-control form-control-sm" placeholder="Departure Date">
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Hotel Images (First Will be Thumb Image)</label>
                                            <input type="file" multiple name="pkg_images[]" class="form-control form-control-sm"
                                                   placeholder="Traveling Date">
                                        </div>
                                    </div>
                                    <!--col-->
                                </div>
                                <!--end-row-->
                                <div class="col-md-12">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h5 class="card-title">Highlights:</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <textarea name="highlights" class="textarea" placeholder="Place some text here"
                                                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $result->highlights }}</textarea>

                                                    </div>
                                                </div>
                                                <!--col-->
                                            </div>
                                            <!--row-->
                                        </div>
                                        <!--card-body-->
                                    </div>
                                    <!--card-->
                                </div>
                                <!--col-->
                                <div class="col-md-12">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h5 class="card-title">Explore:</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Explore Details</label>
                                                        <textarea name="explore_details" class="textarea" placeholder="Place some text here"
                                                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $result->explore_details }}</textarea>

                                                    </div>
                                                </div>
                                                <!--col-->
                                            </div>
                                            <!--row-->
                                        </div>
                                        <!--card-body-->
                                    </div>
                                    <!--card-->
                                </div>
                                <!--col-->
                                <div class="col-md-12">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h5 class="card-title">For Your Info:</h5>
                                        </div>
                                        <div class="card-body">
                                            @php $infos=json_decode($result->your_info,true) @endphp
                                            @foreach($infos as $info)
                                            <div class="row">
                                                <div class="col-xs-12 col-md-10">
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" name="title[]" class="form-control form-control-sm" value="{{ $info['title'] }}" placeholder="Enter...">
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-info btn-sm" style="margin-top: 20px;" onclick="more_info()">Add New Title <i class="fa fa-plus"></i></button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Details</label>
                                                        <textarea name="info_detail[]" class="textarea" placeholder="Place some text here"
                                                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{!! $info['info_detail'] !!}</textarea>
                                                    </div>
                                                </div>
                                                <!--col-->
                                            </div>
                                            <!--row-->
                                            @endforeach
                                            <div class="more-info"></div>
                                        </div>
                                        <!--card-body-->
                                    </div>
                                    <!--card-->
                                </div>
                                <!--col-->
                                <div class="col-md-12">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Price Details:</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <h5>Visa Details:</h5>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Purchase By</label>
                                                        <select class="form-control form-control-sm select2" name="v_purchased_by[]">
                                                            <option value="">Select Vendor</option>
                                                            {!! App\Models\Accounts\TransactionAccount::vendor_dd($result->visa_vendor) !!}
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Visa Price</label>
                                                        <input type="text" name="adult_visa_price" onkeyup="start_pkg_price()" class="form-control form-control-sm visa_price" placeholder="Enter Price" value="{{ $result->adult_visa_price }}">
                                                    </div>
                                                </div>
                                                <!--col-->
                                            </div>
                                            <!--row-->
                                            <h5>Transport Details:</h5>
                                            <?php $transports=json_decode($result->transports,true); ?>
                                            @foreach($transports as $transport)
                                            <div class="row transport">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Purchased By</label>
                                                        <select class="form-control form-control-sm select2" name="t_purchased_by[]">
                                                            <option value="">Select Vendor</option>
                                                            {!! App\Models\Accounts\TransactionAccount::vendor_dd($transport['vendor']) !!}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <select name="transport_city[]" class="form-control form-control-sm select2">
                                                            <option value="0">Select City</option>
                                                            {!! App\Models\City::dropdown($transport['city']) !!}
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Trasnport</label>
                                                        <select name="transport[]" class="form-control form-control-sm select2 vehicle_type">
                                                            <option value="">Select Transport</option>
                                                            {!! App\Helpers\CommonHelper::vehicle_types($transport['transport']) !!}
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Sector</label>
                                                        <input type="text" name="sector[]" class="form-control form-control-sm" placeholder="LHE-JED" value="{{ $transport['sector'] }}">
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Rate</label>
                                                        <input type="number" name="transport_rate[]" onkeyup="start_pkg_price()" class="form-control form-control-sm transport_rate" placeholder="Rate" value="{{ $transport['transport_rate'] }}">
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>Add More</label>
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="more_transport(this)"><i class="fa fa-plus"></i> </button>
                                                    </div>
                                                </div>
                                                <!--col-->
                                            </div>
                                            <!--row-->
                                            @endforeach
                                            <div class="more-transport"></div>
                                            <h5>Hotel Details:</h5>
                                            <?php $hotels=json_decode($result->hotels,true) ?>
                                            @foreach($hotels as $hotel)
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Purchased By</label>
                                                    <select class="form-control form-control-sm select2" name="h_purchased_by[]">
                                                        <option value="">Select Vendor</option>
                                                        {!! App\Models\Accounts\TransactionAccount::vendor_dd($hotel['vendor']) !!}
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <select name="hotel_city[]" class="form-control form-control-sm select2">
                                                            <option value="0">Select City</option>
                                                            {!! App\Models\City::dropdown($hotel['hotel_city']) !!}
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Hotel</label>
                                                        <select name="hotel_name[]" class="form-control form-control-sm select2">
                                                            <option value="0">Select Hotel</option>
                                                            {!! App\Models\Hotel::dropdown($hotel['hotel_name']) !!}
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Hotel Category</label>
                                                        <select name="category[]" class="form-control form-control-sm select2">
                                                            <option value="">Select Category</option>
                                                            <option value="">Economy</option>
                                                            <option value="">3 Star</option>
                                                            <option value="">4 Star</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Room Type</label>
                                                        <select name="room_type[]" class="form-control form-control-sm room_type">
                                                            <option value="">Select Room</option>
                                                            {!! App\Models\RoomType::dropdown($hotel['room_type']) !!}
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>Rate</label>
                                                        <input type="text" name="room_rate[]" onkeyup="start_pkg_price()" class="form-control form-control-sm hotel_rate" placeholder="Rate Per Night" value="{{ $hotel['room_rate'] }}">
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>Add More</label>
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="more_hotel(this)"><i class="fa fa-plus"></i> </button>
                                                    </div>
                                                </div>
                                                <!--col-->
                                            </div>
                                            <!--row-->
                                            @endforeach
                                            <div class="more-hotel"></div>
                                            <h5>Ground Handeling Services:</h5>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Purchase By</label>
                                                        <select class="form-control form-control-sm select2" name="gs_vendor">
                                                            <option value="">Select Vendor</option>
                                                            {!! App\Models\Accounts\TransactionAccount::vendor_dd($result->hotel_name) !!}
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Ground Price</label>
                                                        <input type="text" name="gs_rate" onkeyup="start_pkg_price()" class="form-control form-control-sm gs" placeholder="Enter Price" value="{{ $result->gs_rate }}">
                                                    </div>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Ground Handeling Details</label>
                                                        <textarea name="ground_handeling_details" class="form-control textarea">{{ $result->ground_handeling_details }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--row-->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-5 float-right">
                                                        <div class="card">
                                                            <!--.card-header -->
                                                            <div class="card-body">
                                                                <table class="table">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>Add Markup</td>
                                                                        <td><input name="markup" type="text" class="form-control form-control-sm markup" onkeyup="start_pkg_price()" placeholder="0.00" value="{{ $result->markup }}"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Start Package Price:</th>
                                                                        <td><input name="starting_price" type="text" class="form-control form-control-sm" id="pkg_price" placeholder="0.00" value="{{ $result->starting_price }}"></td>
                                                                    </tr>

                                                                    </tbody></table>
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.card -->
                                                    </div>
                                                </div>
                                                <!--col-->
                                            </div>
                                            <!--row-->
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!--card card-primary-->
                                </div>
                                <!-- /.card-body -->
                                <div class="col-md-12">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h5 class="card-title">Terms & Conditions:</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Terms & Conditions</label>
                                                        <textarea name="term_conditions" class="textarea" placeholder="Place some text here"
                                                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $result->term_conditions }}</textarea>

                                                    </div>
                                                </div>
                                                <!--col-->
                                            </div>
                                            <!--row-->
                                        </div>
                                        <!--card-body-->
                                    </div>
                                    <!--card-->
                                </div>
                                <!--col-->
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-sm btn-success btn-flat float-right">Update</button>
                                    </div>
                                </div>
                                <!--end-row-->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </form>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
    @include('cms.Tours.tour.inc_js')
@endsection<!-- jQuery -->
