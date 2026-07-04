@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Company Setup</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Business Setup</li>
                            <li class="breadcrumb-item active">Company Setup</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('company_setup.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input placeholder="Company Name" class="form-control form-control-sm" name="name" type="text" value="{{ old('name', $company->name) }}" style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Company Contact Name</label>
                                            <input placeholder="Company Contact Name" class="form-control form-control-sm" name="contact_name" type="text" value="{{ old('contact_name', $company->contact_name) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Company Contact Mobile</label>
                                            <input placeholder="Company Contact Mobile" class="form-control form-control-sm" name="contact_mobile" type="text" value="{{ old('contact_mobile', $company->contact_mobile) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Company Phone</label>
                                            <input placeholder="Company Phone" class="form-control form-control-sm" name="phone" type="text" value="{{ old('phone', $company->phone) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Company Email</label>
                                            <input placeholder="Company Email" class="form-control form-control-sm" name="email" type="text" value="{{ old('email', $company->email) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Company Website</label>
                                            <input placeholder="Company Website" class="form-control form-control-sm" name="website" type="text" value="{{ old('website', $company->website) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Govt. Lic No</label>
                                            <input placeholder="Govt. Lic No" class="form-control form-control-sm" name="govt_lic_no" type="text" value="{{ old('govt_lic_no', $company->govt_lic_no) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>IATA No</label>
                                            <input placeholder="IATA No" class="form-control form-control-sm" name="iata_no" type="text" value="{{ old('iata_no', $company->iata_no) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>NTN</label>
                                            <input placeholder="NTN" class="form-control form-control-sm" name="ntn" type="text" value="{{ old('ntn', $company->ntn) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Powered By</label>
                                            <input placeholder="Powered By" class="form-control form-control-sm" name="powered_by" type="text" value="{{ old('powered_by', $company->powered_by) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Footer Contact No</label>
                                            <input placeholder="Footer Contact No" class="form-control form-control-sm" name="contact_no" type="text" value="{{ old('contact_no', $company->contact_no) }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Company Address</label>
                                            <textarea placeholder="Company Address" class="form-control form-control-sm" name="address" rows="2">{{ old('address', $company->address) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Company Logo</label>
                                            <div class="mb-2">
                                                <img src="{{ $company->logo_url }}" alt="Company Logo" style="max-height: 80px; border: 1px solid #eee; padding: 4px; background:#fff;" onerror="this.style.display='none'">
                                            </div>
                                            <input type="file" class="form-control-file" name="logo" accept="image/*">
                                            <small class="form-text text-muted">Upload a new logo to replace the current one (JPG, PNG, GIF, WEBP or SVG, max 2 MB).</small>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </form>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
@endsection<!-- jQuery -->