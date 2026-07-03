@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">Edit General Account</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('general-accounts.index') }}">General Accounts</a></li>
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
                        <div class="card-header"><h3 class="card-title pt-1">{{ $generalAccount->name }}</h3></div>
                        @include('setup.partials.flash')
                        <form action="{{ route('general-accounts.update', $generalAccount->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            @include('Setup.general_accounts._form', ['generalAccount' => $generalAccount, 'submitLabel' => 'Update General Account'])
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
