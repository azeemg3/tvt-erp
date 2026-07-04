<?php
// Shared "Administration" navigation reused by every module (permission gated).
$appication_setup=['categories', 'currencies', 'product_types', 'products', 'regions',
    'currency_api','currency_history','sources','clients', 'continents', 'countries',
    'division','district', 'cities', 'province', 'areas','mosques'];
$user=['users', 'create', 'roles', 'permission'];
$hr=['designation', 'department', 'employee'];
$bus_setup=['company_setup', 'branches'];
$sale=['Sale'];
?>
@can('application_setup_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $appication_setup)){ echo 'menu-open'; } elseif(in_array(Request::segment(3), $appication_setup)) echo 'menu-open'; elseif(in_array(Request::segment(2), $appication_setup)) echo 'menu-open';
    elseif(in_array(Request::segment(3), $user)){ echo 'menu-open'; } elseif(in_array(Request::segment(2), $hr)){ echo 'menu-open'; }
    elseif(in_array(Request::segment(1), $bus_setup)){ echo 'menu-open'; } ?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs fa-xs"></i>
            <p>
                Application Setting
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('email_template_view')
                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $sale)) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link">
                        <i class='nav-icon fas fa-envelope fa-xs'></i>
                        <p>
                            Email Template Management
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                </li>
            @endcan
            <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $user)) echo 'menu-open'; ?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        {{ __('user_management.user_management') }}
                        <i class="nav-icon fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ (request()->is('Application_Setup/user_management/users')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>User List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.create') }}" class="nav-link {{ (request()->is('Application_Setup/user_management/users/create')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>Create New User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}" class="nav-link {{ (request()->is('Application_Setup/user_management/roles')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('permission.index') }}" class="nav-link {{ (request()->is('Application_Setup/user_management/permission')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>Permissions</p>
                        </a>
                    </li>
                </ul>
            </li>
            @can('hr_view')
                <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $hr)) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            {{ __('main.hr') }}
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('hr_setup_view')
                            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $hr)) echo 'menu-open'; ?>">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-cog fa-xs"></i>
                                    <p>
                                        HR Setup
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('designation_view')
                                        <li class="nav-item">
                                            <a href="{{ route('designation.index') }}" class="nav-link {{ (request()->is('Hr/designation')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Designation</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('department_view')
                                        <li class="nav-item">
                                            <a href="{{ route('department.index') }}" class="nav-link {{ (request()->is('Hr/department')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Department</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('employee_details_view')
                            <li class="nav-item">
                                <a href="{{ route('employee.index') }}" class="nav-link {{ (request()->is('Hr/employee')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Employee Details</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('business_setup_view')
                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $bus_setup)) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-business-time"></i>
                        <p>
                            {{ __('main.business_setup') }}
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('company_setup.create') }}" class="nav-link {{ (request()->is('company_setup/create')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Company Setup</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('branches.index') }}" class="nav-link {{ (request()->is('branches')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Branches</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <li class="nav-item">
                <a href="{{ route('currencies.index') }}" class="nav-link {{ request()->is('currencies')?'active':'' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Currency</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('currency_history') }}" class="nav-link {{ request()->is('currency_history')?'active':'' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Currency Rate History</p>
                </a>
            </li>
            @can('location_setup_view')
                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $appication_setup)) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-location-arrow fa-xs"></i>
                        <p>
                            Location Setup
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('continents.index') }}" class="nav-link {{ request()->is('continents')?'active':'' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Continents</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('countries.index') }}" class="nav-link {{ request()->is('countries')?'active':'' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Countries</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('province.index') }}" class="nav-link {{ request()->is('province')?'active':'' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Province/State</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('division.index') }}" class="nav-link {{ request()->is('division')?'active':'' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Divisions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('district.index') }}" class="nav-link {{ request()->is('district')?'active':'' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>District</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cities.index') }}" class="nav-link {{ request()->is('cities')?'active':'' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Cities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('areas.index') }}" class="nav-link {{ request()->is('areas')?'active':'' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Areas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mosques.index') }}" class="nav-link {{ request()->is('mosques')?'active':'' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Mosques</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        </ul>
    </li>
@endcan
