<?php
// Active-state helpers scoped to the OTA module.
$providors=['providors','hotel_providor','visa_providor','transport_providor'];
$acc_providor=['account_statement'];
$accounts=['account_statement'];
$visa=['visa_rate'];
$flight=['airlines', 'ticket_source'];
$hotel=['hotel_rate','hotels','room_types'];
$transport=['transport_rate'];
$cms=['cms','quarantine','customize_packages','tour'];
$guest=['guest', 'guest_users'];
$api=['api_management', 'flight'];
?>
@if(Auth::user()->hasRole('Providor') || Auth::user()->isAdmin())
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $providors)) echo 'menu-open'; ?>">
        <a href="#" class="nav-link">
            <i class='nav-icon fas fa-chart-bar fa-xs'></i>
            <p>
                Providors
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        @php
            $sp=\App\Helpers\CommonHelper::sp_access();
            if($sp['result']!==null){
                $sp=explode(',',$sp['result']['product_includes']);
            }
        @endphp
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ url('providors') }}" class="nav-link {{ (request()->is('providors')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if(in_array(1,$sp))
            <li class="nav-item">
                <a href="{{ url('providors') }}" class="nav-link {{ (request()->is('')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Flight Providor</p>
                </a>
            </li>
            @endif
            @if(in_array('2',$sp))
            <li class="nav-item">
                <a href="{{ route('hotel_providor.index') }}" class="nav-link {{ (request()->is('providors/hotel_providor')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Hotel Providor</p>
                </a>
            </li>
            @endif
            @if(in_array('3',$sp))
            <li class="nav-item">
                <a href="{{ route('visa_providor.index') }}" class="nav-link {{ (request()->is('providors/visa_providor')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Visa Providor</p>
                </a>
            </li>
            @endif
            @if(in_array('4',$sp))
            <li class="nav-item">
                <a href="{{ route('transport_providor.index') }}" class="nav-link {{ (request()->is('providors/transport_providor')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Transport Providor</p>
                </a>
            </li>
            @endif
            @if(in_array(5,$sp))
            <li class="nav-item">
                <a href="{{ url('providors') }}" class="nav-link {{ (request()->is('')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Insurance Providor</p>
                </a>
            </li>
            @endif
            <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $acc_providor)) echo 'menu-open';?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-calendar fa-xs"></i>
                    <p>
                        Accounts
                        <i class="nav-icon fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('providors/accounts/account_statement') }}" class="nav-link {{ (request()->is('providors/accounts/account_statement')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>General Ledger Statement</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
@endif
@can('visa_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $visa)) echo 'menu-open' ?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-globe"></i>
            <p>
                Visa
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('visa_rate_view')
                <li class="nav-item">
                    <a href="{{ route('visa_rate.index') }}" class="nav-link {{ request()->is('Application_Setup/Rate_Setup/visa_rate')?'active':'' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Visa Rate</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
@can('flight_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $flight)) echo 'menu-open';?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-plane fa-xs"></i>
            <p>
                Flight
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('ticket_source_view')
                <li class="nav-item">
                    <a href="{{ route('ticket_source.index') }}" class="nav-link {{ request()->is('Application_Setup/ticket_source')? 'active':'' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Ticket Source</p>
                    </a>
                </li>
            @endcan
            @can('airline_view')
                <li class="nav-item">
                    <a href="{{ route('airlines.index') }}" class="nav-link {{ request()->is('Application_Setup/airlines')?'active':'' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Airlines</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('api_management/flight')?'active':'' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>All Bookings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('guest_users.index') }}" class="nav-link {{ (request()->is('guest')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Service Providors</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
@can('hotel_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $hotel)) echo 'menu-open';
    elseif(in_array(Request::segment(3), $hotel)) echo 'menu-open';?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-building"></i>
            <p>
                Hotel
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('hotel.index') }}" class="nav-link {{ request()->is('Application_Setup/hotel')?'active':'' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Hotels</p>
                </a>
            </li>
            @can('room_type_view')
                <li class="nav-item">
                    <a href="{{ route('room_types.index') }}" class="nav-link {{ request()->is('Application_Setup/room_types')?'active':'' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Room Types</p>
                    </a>
                </li>
            @endcan
            @can('hotel_rate_list_view')
                <li class="nav-item">
                    <a href="{{ route('hotel_rate.index') }}" class="nav-link {{ request()->is('Application_Setup/Rate_Setup/hotel_rate')?'active':'' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Hotel Rate List</p>
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a href="{{ route('guest_users.index') }}" class="nav-link {{ (request()->is('guest')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Service Providors</p>
                </a>
            </li>
        </ul>
    </li>
@endcan
@can('transport_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $transport)) echo 'menu-open';?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-car"></i>
            <p>
                Transport
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('transport_rate_list_view')
                <li class="nav-item">
                    <a href="{{ route('transport_rate.index') }}" class="nav-link {{ request()->is('Application_Setup/Rate_Setup/transport_rate')?'active':'' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Transport Rate List</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
@can('tour_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $cms)) echo 'menu-open'; ?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-kaaba"></i>
            <p>
                Tours
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('tour.index') }}" class="nav-link {{ request()->is('cms/tours/tour')?'active':'' }}
                {{ request()->is('cms/tours/tour/create')?'active':'' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Tour</p>
                </a>
            </li>
        </ul>
    </li>
@endcan
@can('guest_user_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $guest)) echo 'menu-open';
    else if(in_array(Request::segment(2), $guest)) echo 'menu-open';?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-alt"></i>
            <p>
                B2C
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ url('guest') }}" class="nav-link {{ (request()->is('guest')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guest_users.index') }}" class="nav-link {{ (request()->is('guest/guest_users')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>User List</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guest_users.index') }}" class="nav-link {{ (request()->is('guest')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Service Providors</p>
                </a>
            </li>
        </ul>
    </li>
@endcan
@if(Auth::user()->isAdmin())
    <li class="nav-item has-treeview <?php if(Request::segment(2) == 'lead_reports') echo 'menu-open'; ?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-area"></i>
            <p>
                {{ __('main.reports') }}
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ (request()->is('reports/lead_reports*')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Lead Reports
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('reports/lead_reports/customer_lead_reports') }}" class="nav-link {{ (request()->is('reports/lead_reports/customer_lead_reports')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>Customer Lead Reports</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
@endif
@can('api_management_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $api)){ echo 'menu-open'; } ?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tasks fa-xs"></i>
            <p>
                Api Management
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ url('api_management') }}" class="nav-link {{ (request()->is('api_management')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Api Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('currency_api') }}" class="nav-link {{ request()->is('currency_api')?'active':'' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>API Currencis List</p>
                </a>
            </li>
            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $api)) echo 'menu-open'; ?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-plane fa-xs"></i>
                    <p>
                        Flight
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('api_management/flight')?'active':'' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>All Bookings</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $api)) echo 'menu-open'; ?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-building fa-xs"></i>
                    <p>
                        Hotel
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('api_management/flight') }}" class="nav-link {{ request()->is('api_management/flight')?'active':'' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>All Bookings</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $api)) echo 'menu-open'; ?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bus fa-xs"></i>
                    <p>
                        Transport
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('api_management/flight') }}" class="nav-link {{ request()->is('api_management/flight')?'active':'' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>All Bookings</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $api)) echo 'menu-open'; ?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-globe fa-xs"></i>
                    <p>
                        Visa
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('api_management/flight') }}" class="nav-link {{ request()->is('api_management/flight')?'active':'' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>All Bookings</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $api)) echo 'menu-open'; ?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-medkit fa-xs"></i>
                    <p>
                        Insurance
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('api_management/flight') }}" class="nav-link {{ request()->is('api_management/flight')?'active':'' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>All Bookings</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $api)) echo 'menu-open'; ?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-credit-card fa-xs"></i>
                    <p>
                        Gateway
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('api_management/flight') }}" class="nav-link {{ request()->is('api_management/flight')?'active':'' }}">
                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                            <p>All</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
@endcan
