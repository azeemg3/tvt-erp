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
                            <li class="breadcrumb-item">User Management</li>
                            <li class="breadcrumb-item active">User List</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>User Status</th>
                                    <th width="280px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $key => $user)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if(!empty($user->getRoleNames()))
                                                @foreach($user->getRoleNames() as $v)
                                                    <label class="badge badge-success">{{ $v }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->status==0) Active @endif
                                            @if($user->status==1) Inactive @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-xs btn-info" href="{{ route('users.show',$user->id) }}"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-xs btn-primary" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-edit"></i></a>
                                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        {{--<div class="card-footer clearfix">--}}
                            {{--<ul class="pagination pagination-sm m-0 float-right">--}}
                                {{--<li class="page-item"><a class="page-link" href="#">«</a></li>--}}
                                {{--<li class="page-item active"><a class="page-link" href="#">1</a></li>--}}
                                {{--<li class="page-item"><a class="page-link" href="#">»</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
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