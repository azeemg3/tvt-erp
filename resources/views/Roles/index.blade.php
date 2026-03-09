@extends('layouts.app')


@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Header start -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item">User Management</li>
                                <li class="breadcrumb-item active">Roles</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- End start -->
            <div class="row">
                <!-- Form Control starts -->
                <div class="col-md-12">
                    <div class="card">
                        <form id="form">
                            <div class="card-block">
                                <div class="col-sm-12 table-responsive pad0">
                                    <a href="{{ route('roles.create') }}" class="btn btn-xs btn-primary float-right">Add New</a>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Name</th>
                                            <th width="280px">Action</th>
                                        </tr>
                                        @foreach ($roles as $key => $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <a class="btn btn-info btn-xs" href="{{ route('roles.show',$role->id) }}"><i class="fa fa-eye"></i> </a>
                                                    {{--@can('role-edit')--}}
                                                        <a class="btn btn-primary btn-xs" href="{{ route('roles.edit',$role->id) }}"><i class="fa fa-edit"></i> </a>
                                                    {{--@endcan--}}
                                                    {{--@can('role-delete')--}}
                                                        <a class="btn btn-danger btn-xs" href="{{ route('roles.edit',$role->id) }}"><i class="fa fa-trash"></i> </a>
                                                    {{--@endcan--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                </div>
                            </div>
                            <!--card-block-->
                        </form>
                    </div>
                    <!--card-->
                </div>
                <!-- Form Control ends -->
            </div>
        </div>
    </div>
    {{--@if (count($errors) > 0)--}}
    {{--<div class="alert alert-danger">--}}
    {{--<strong>Whoops!</strong> There were some problems with your input.<br><br>--}}
    {{--<ul>--}}
    {{--@foreach ($errors->all() as $error)--}}
    {{--<li>{{ $error }}</li>--}}
    {{--@endforeach--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--@endif--}}
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
@endsection