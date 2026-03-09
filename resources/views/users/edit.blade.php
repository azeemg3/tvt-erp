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
                            <li class="breadcrumb-item">Users</li>
                            <li class="breadcrumb-item active">Edit User</li>
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
                            <form action="{{ route('users.update', $user->id) }}" method="post">
                                @CSRF
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input placeholder="Name" class="form-control form-control-sm" name="name" value="{{ $user->name }}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input placeholder="Email" class="form-control form-control-sm" value="{{ $user->email }}" name="email" type="text">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input placeholder="Password" class="form-control form-control-sm" name="password" type="password">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Confirm Password:</label>
                                            <input placeholder="Confirm Password" class="form-control form-control-sm" name="confirm-password" type="password" value="" style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <strong>Role:</strong>
                                            <select class="form-control form-control-sm" name="roles">
                                                <option value="0">Select Role</option>
                                                @foreach($roles as $role)
                                                    <option @if(in_array($role, $userRole)) selected @endif value="{{ $role}}">{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <strong>Status:</strong>
                                            <select class="form-control form-control-sm"  name="status">
                                                <option @if($user->status==0) selected @endif value="0">Active</option>
                                                <option @if($user->status==1) selected @endif value="1">InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--end-row-->
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-sm btn-success btn-flat float-right">Update</button>
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
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
@endsection<!-- jQuery -->