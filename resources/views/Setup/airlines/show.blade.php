@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">Airline Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('airlines.index') }}">Airlines</a></li>
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
                            <h3 class="card-title pt-1">{{ $airline->name }}</h3>
                            <div class="card-tools">
                                @can('airline_edit')
                                    <a href="{{ route('airlines.edit', $airline->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                @endcan
                                <a href="{{ route('airlines.index') }}" class="btn btn-secondary btn-xs">Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <tr><th style="width:40%;">Airline Name</th><td>{{ $airline->name }}</td></tr>
                                        <tr><th>IATA Code</th><td>{{ $airline->iata_code ?: '-' }}</td></tr>
                                        <tr><th>ICAO Code</th><td>{{ $airline->icao_code ?: '-' }}</td></tr>
                                        <tr><th>Numeric Code</th><td>{{ $airline->numeric_code ?: '-' }}</td></tr>
                                        <tr><th>Country</th><td>{{ optional($airline->countryInfo)->name ?: '-' }}</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <tr><th style="width:40%;">Status</th><td>
                                            @if ((int) $airline->status === 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td></tr>
                                        <tr><th>Created By</th><td>{{ optional($airline->creator)->name ?: '-' }}</td></tr>
                                        <tr><th>Created At</th><td>{{ optional($airline->created_at)->format('d M Y, h:i A') }}</td></tr>
                                        <tr><th>Updated At</th><td>{{ optional($airline->updated_at)->format('d M Y, h:i A') }}</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <strong>Remarks</strong>
                                    <p class="text-muted">{{ $airline->remarks ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
