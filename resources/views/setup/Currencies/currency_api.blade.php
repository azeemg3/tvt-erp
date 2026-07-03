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
                            <li class="breadcrumb-item">Setup</li>
                            <li class="breadcrumb-item active">Currency List</li>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Select Currency</label>
                                        <select class="form-control form-control-sm" onchange="search_currency(this.value)">
                                            @foreach($result as $key=>$val)
                                                <option @if($key==$base) selected @endif value="{{ $key }}">{{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Currency Symbol</th>
                                    <th>Conversion Rate</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                @foreach($result as $key=>$val)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $key }}</td>
                                        <td>{{ $val }}</td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

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
        function search_currency(id) {
            window.location.href='{{ url('currency_api') }}/'+id;
        }
    </script>
@endsection<!-- jQuery -->