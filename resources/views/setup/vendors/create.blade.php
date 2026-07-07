@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">Add Vendor</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header"><h3 class="card-title pt-1">New Vendor</h3></div>
                        @include('setup.partials.flash')
                        <form action="{{ route('vendors.store') }}" method="POST" autocomplete="off">
                            @csrf
                            @include('setup.vendors._form', ['vendor' => null, 'submitLabel' => 'Create Vendor'])
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        (function initSelect2() {
            if (typeof window.jQuery === 'undefined' || !jQuery.fn || !jQuery.fn.select2) {
                return setTimeout(initSelect2, 150);
            }
            $('.select2').select2({theme: 'bootstrap4'});
        })();
    </script>
@endsection
