@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">Client Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="card-title pt-1">{{ $client->client_name }}</h3>
                            <div class="card-tools">
                                @can('client_edit')
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                @endcan
                                <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-xs">Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <tr><th style="width:40%;">Client Code</th><td>{{ $client->client_code }}</td></tr>
                                        <tr><th>Ledger A/C Code</th><td>{{ optional($client->account)->code }}</td></tr>
                                        <tr><th>Client Name</th><td>{{ $client->client_name }}</td></tr>
                                        <tr><th>Email</th><td>{{ $client->email }}</td></tr>
                                        <tr><th>Mobile</th><td>{{ $client->mobile }}</td></tr>
                                        <tr><th>C/O SPO</th><td>{{ optional($client->assignedUser)->name }}</td></tr>
                                        <tr><th>Category</th><td>{{ $client->category }}</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <tr><th style="width:40%;">Recovery Officer</th><td>{{ optional($client->recoveryOfficer)->name }}</td></tr>
                                        <tr><th>Credit Limit</th><td>{{ number_format((float) $client->credit_limit, 2) }}</td></tr>
                                        <tr><th>Credit Days</th><td>{{ $client->credit_days }}</td></tr>
                                        <tr><th>Status</th><td>
                                            @if ((int) $client->status === 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td></tr>
                                        <tr><th>Created By</th><td>{{ optional($client->creator)->name }}</td></tr>
                                        <tr><th>Created At</th><td>{{ optional($client->created_at)->format('d M Y, h:i A') }}</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <strong>Address</strong>
                                    <p class="text-muted">{{ $client->address ?: '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Remarks</strong>
                                    <p class="text-muted">{{ $client->remarks ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
