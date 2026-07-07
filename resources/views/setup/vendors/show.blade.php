@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">Vendor Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
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
                            <h3 class="card-title pt-1">{{ $vendor->vendor_name }}</h3>
                            <div class="card-tools">
                                @can('vendor_edit')
                                    <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                @endcan
                                <a href="{{ route('vendors.index') }}" class="btn btn-secondary btn-xs">Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <tr><th style="width:40%;">Vendor Code</th><td>{{ $vendor->vendor_code }}</td></tr>
                                        <tr><th>Ledger A/C Code</th><td>{{ optional($vendor->account)->code }}</td></tr>
                                        <tr><th>Vendor Name</th><td>{{ $vendor->vendor_name }}</td></tr>
                                        <tr><th>Vendor Type</th><td>{{ $vendor->vendor_type }}</td></tr>
                                        <tr><th>Contact Person</th><td>{{ $vendor->contact_person }}</td></tr>
                                        <tr><th>Mobile</th><td>{{ $vendor->mobile }}</td></tr>
                                        <tr><th>Phone</th><td>{{ $vendor->phone }}</td></tr>
                                        <tr><th>Email</th><td>{{ $vendor->email }}</td></tr>
                                        <tr><th>Airline Code</th><td>{{ $vendor->airline_code }}</td></tr>
                                        <tr><th>IATA Code</th><td>{{ $vendor->iata_code }}</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <tr><th style="width:40%;">Credit Limit</th><td>{{ number_format((float) $vendor->credit_limit, 2) }}</td></tr>
                                        <tr><th>Credit Days</th><td>{{ $vendor->credit_days }}</td></tr>
                                        <tr><th>Opening Balance</th><td>{{ number_format((float) $vendor->opening_balance, 2) }}</td></tr>
                                        <tr><th>City</th><td>{{ $vendor->city }}</td></tr>
                                        <tr><th>Country</th><td>{{ $vendor->country }}</td></tr>
                                        <tr><th>GST / VAT No</th><td>{{ $vendor->gst_vat_no }}</td></tr>
                                        <tr><th>Status</th><td>
                                            @if ((int) $vendor->status === 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td></tr>
                                        <tr><th>Created By</th><td>{{ optional($vendor->creator)->name }}</td></tr>
                                        <tr><th>Created At</th><td>{{ optional($vendor->created_at)->format('d M Y, h:i A') }}</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <strong>Address</strong>
                                    <p class="text-muted">{{ $vendor->address ?: '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Remarks</strong>
                                    <p class="text-muted">{{ $vendor->remarks ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
