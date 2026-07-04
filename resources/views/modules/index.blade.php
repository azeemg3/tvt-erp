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
        .module-launcher .module-card {
            border: none;
            border-radius: .5rem;
            overflow: hidden;
            transition: transform .15s ease-in-out, box-shadow .15s ease-in-out;
            height: 100%;
        }
        .module-launcher a.module-link:hover .module-card {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .35);
        }
        .module-launcher .module-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #fff;
            margin-bottom: 1rem;
        }
        .module-launcher a.module-link,
        .module-launcher a.module-link:hover {
            text-decoration: none;
            color: inherit;
        }
        .module-launcher .module-desc {
            color: #6c757d;
            min-height: 48px;
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

        @if(count($modules))
            <div class="row">
                @foreach($modules as $module)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('modules.select', $module['slug']) }}" class="module-link d-block h-100">
                            <div class="card module-card text-center">
                                <div class="card-body py-4">
                                    <span class="module-icon {{ $module['color'] ?? 'bg-gradient-primary' }}">
                                        <i class="{{ $module['icon'] ?? 'fas fa-cube' }}"></i>
                                    </span>
                                    <h4 class="mb-2">{{ $module['label'] }}</h4>
                                    <p class="module-desc mb-3">{{ $module['description'] ?? '' }}</p>
                                    <span class="btn btn-sm {{ $module['color'] ?? 'bg-gradient-primary' }} text-white px-4">
                                        Open <i class="fas fa-arrow-right ml-1"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <h4 class="mb-2">No modules assigned</h4>
                    <p class="text-muted mb-0">Your account doesn't have access to any module yet. Please contact your administrator.</p>
                </div>
            </div>
        @endif
    </div>

    <script src="{{ URL::asset('public/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('public/dist/js/adminlte.js') }}"></script>
</body>
</html>
