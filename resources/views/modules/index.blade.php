<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Modules</title>
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('public/dist/img/favicon.ico') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ URL::asset('public/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('public/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/dist/css/style.css') }}">
    <style>
        body.module-launcher {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 55%, #2c5364 100%);
        }
        .module-launcher .launcher-header {
            color: #fff;
        }
        .module-launcher a.module-link:hover .module-card {
            box-shadow: 0 12px 28px rgba(0, 0, 0, .35);
        }
    </style>
</head>
<body class="hold-transition module-launcher">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 launcher-header">
            <div>
                <h2 class="mb-0">{{ $company->name }}</h2>
                <small class="text-white-50">Welcome, {{ auth()->user()->name }} &mdash; choose a module to continue</small>
            </div>
            <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </a>
        </div>

        <x-module-grid
            :tiles="$moduleTiles"
            variant="launcher"
            empty-title="No modules assigned"
            empty-message="Your account doesn't have access to any module yet. Please contact your administrator."
        />
    </div>

    <script src="{{ URL::asset('public/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('public/dist/js/adminlte.js') }}"></script>
</body>
</html>
