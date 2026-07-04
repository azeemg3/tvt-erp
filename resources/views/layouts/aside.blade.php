@php
    // Resolve module context (shared by App\Http\Middleware\SetActiveModule,
    // with a safe fallback in case the view is rendered outside that pipeline).
    $__modules   = $accessibleModules ?? \App\Support\ModuleManager::accessible();
    $__activeSlug = $activeModuleSlug ?? \App\Support\ModuleManager::activeSlug();
    $__active    = $activeModule ?? \App\Support\ModuleManager::find($__activeSlug);
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('modules.index') }}" class="brand-link elevation-4 navbar-info" style="padding: 12px !important;" title="Switch module">
        <span class="brand-text font-weight-light">{{ $company->name }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ URL::asset('public/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Active module + switcher -->
        @if($__active)
            <div class="px-2 pb-2">
                <div class="dropdown">
                    <a href="#" class="btn btn-block btn-sm text-left {{ $__active['color'] ?? 'bg-gradient-primary' }} text-white d-flex align-items-center justify-content-between" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="{{ $__active['icon'] ?? 'fas fa-cube' }} mr-2"></i>{{ $__active['label'] }}</span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right w-100">
                        @foreach($__modules as $__m)
                            <a class="dropdown-item {{ $__m['slug'] === $__activeSlug ? 'active' : '' }}" href="{{ route('modules.select', $__m['slug']) }}">
                                <i class="{{ $__m['icon'] ?? 'fas fa-cube' }} mr-2"></i>{{ $__m['label'] }}
                            </a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('modules.index') }}">
                            <i class="fas fa-th-large mr-2"></i>All Modules
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                @can('dashboard_view')
                    <li class="nav-item has-treeview">
                        <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p> Dashboard </p>
                        </a>
                    </li>
                @endcan

                {{-- Module-specific navigation --}}
                @if($__active && !empty($__active['sidebar']))
                    @includeIf($__active['sidebar'])
                @endif

                {{-- Shared administration navigation (permission gated) --}}
                @include('layouts.sidebars.partials.administration')
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
