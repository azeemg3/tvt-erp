@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">Edit Client</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header"><h3 class="card-title pt-1">{{ $client->client_name }} ({{ $client->client_code }})</h3></div>
                        @include('setup.partials.flash')
                        <form action="{{ route('clients.update', $client->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            @include('setup.clients._form', ['client' => $client, 'submitLabel' => 'Update Client'])
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
