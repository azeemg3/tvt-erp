<?php
$lead=['lead','pending_leads', 'my_leads', 'all_leads'];
$user=['users', 'create', 'roles', 'permission'];
$appication_setup=['categories', 'currencies', 'product_types', 'products', 'regions',
    'currency_api','currency_history','sources','clients', 'continents', 'countries',
    'division','district', 'cities', 'province', 'areas','mosques'];
$accounts=['root_accounts', 'dashboard', 'head_accounts', 'subhead_accounts',
    'trans_accounts', 'payment_vouchers', 'receipt_vouchers','journal_vouchers','ledger',
    'financial_year','agent_wallet','service_providors'];
$agent_disount=['custom_pkg_discount'];
$account_reports=['ledger_report','trail_balance','account_day_book','balance_sheet',
    'income_statement'];
$hr=['designation', 'department', 'employee'];
$bus_setup=['company_setup', 'branches'];
$sale=['Sale'];
$cms=['cms','quarantine','customize_packages','tour'];
$agent=[ 'orders', 'inquires', 'agent_price','agent_commission'];
$admin=['agent','subadmin','go'];
$api=['api_management', 'flight'];
$statistics=['statistic','admin_statistic','subadmin_statistic','agent_statistic'];
$guest=['guest', 'guest_users'];
$booking_confirmation=['hotel_confirimation','transport_confirimation'];
$umrah=['group_details','mofa_list','transport_cycle','ground_handling_rate',
    'transport_reservation','hotel_reservation','ziarat_rate','agent_umrah','umrah_draft'];
$bookings=['bookings','tour_booking'];
$flight=['airlines', 'ticket_source'];
$hotel=['hotel_rate','hotels','room_types'];
$transport=['transport_rate'];
$visa=['visa_rate'];
$umrah_reports=['arrival_report','departure_report','checkin_report','checkout_report'];
$providors=['providors','hotel_providor','visa_providor','transport_providor'];
$acc_providor=['account_statement'];
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('home') }}" class="brand-link elevation-4 navbar-info" style="padding: 12px !important;">
        {{--<img src="{{ URL::asset('public/dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">--}}
        <span class="brand-text font-weight-light">YourOwn-Trips</span>
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
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @can('dashboard_view')
                    <li class="nav-item has-treeview">
                        <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p> Dashboard </p>
                        </a>
                    </li>
                @endcan
                @if(Auth::user()->getRoleNames()[0]=='Providor' || Auth::user()->getRoleNames()[0]=='Admin')
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
                        <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $accounts)) echo 'menu-open';
                        if(in_array(Request::segment(3), $acc_providor)) echo 'menu-open';?>">
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
                @can('statistics_view')
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $statistics)) echo 'menu-open'; ?>">
                        <a href="#" class="nav-link">
                            <i class='nav-icon fas fa-chart-bar fa-xs'></i>
                            <p>
                                Statistics
                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('statistic.index') }}" class="nav-link {{ (request()->is('statistics/statistic')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Statistics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('statistics/admin_statistic') }}" class="nav-link {{ (request()->is('statistics/admin_statistic')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Admin Statistics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('statistics/subadmin_statistic') }}" class="nav-link {{ (request()->is('statistics/subadmin_statistic')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Sub Admin Statistics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('statistics/agent_statistic') }}" class="nav-link {{ (request()->is('statistics/agent_statistic')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Agent Statistics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('statistics/agent_statistic') }}" class="nav-link {{ (request()->is('statistics')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Group Organizer</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('lms_view')
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $lead)) echo 'menu-open'; ?>">
                        <a href="#" class="nav-link">
                            <i class='nav-icon fas fa-graduation-cap fa-xs'></i>
                            <p>
                                {{ __('lms.lms') }}
                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('lead.index') }}" class="nav-link {{ (request()->is('lms/lead')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>{{ __('lms.dashboard') }}</p>
                                </a>
                            </li>
                            @can('lead_create')
                                <li class="nav-item">
                                    <a href="{{ route('lead.create') }}" class="nav-link {{ (request()->is('lms/lead/create')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>{{ __('lms.create_lead') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('pending_leads_view')
                                <li class="nav-item">
                                    <a href="{{ url('lms/pending_leads') }}" class="nav-link {{ (request()->is('lms/pending_leads')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>{{ __('lms.pending_leads') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('my_leads_view')
                                <li class="nav-item">
                                    <a href="{{ url('lms/my_leads') }}" class="nav-link {{ (request()->is('lms/my_leads')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>{{ __('lms.my_lead') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('all_leads_view')
                                <li class="nav-item">
                                    <a href="{{ url('lms/all_leads') }}" class="nav-link {{ (request()->is('lms/all_leads')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>{{ __('lms.all_lead') }}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
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
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $transport)) echo 'menu-open';
                    ?>">
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
                @can('umrah_view')
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $umrah)) echo 'menu-open';
                    elseif(in_array(Request::segment(2), $booking_confirmation)) echo 'menu-open'; if(in_array(Request::segment(3), $booking_confirmation)) echo 'menu-open';
                    elseif(in_array(Request::segment(3), $umrah)) echo 'menu-open';?>">
                        <a href="#" class="nav-link">
                            <i class='nav-icon fas fa-kaaba fa-xs'></i>
                            <span id="umrah_count"></span>
                            <p>
                                {{ __('umrah_mng.umrah_management') }}
                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('reservation_view')
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $accounts)) echo 'menu-open';
                                if(in_array(Request::segment(2), $umrah)) echo 'menu-open';?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-calendar fa-xs"></i>
                                        <p>
                                            Reservation
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('hotel_reservation_view')
                                            <li class="nav-item">
                                                <a href="{{ route('hotel_reservation.index') }}" class="nav-link {{ (request()->is('umrah/hotel_reservation')) ? 'active' : '' }}">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Hotel Reservations</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('transport_reservation_view')
                                            <li class="nav-item">
                                                <a href="{{ route('transport_reservation.index') }}" class="nav-link {{ (request()->is('umrah/transport_reservation')) ? 'active' : '' }}">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Transport Reservation</p>
                                                </a>
                                            </li>
                                        @endcan
                                        <li class="nav-item">
                                            <a href="{{ route('transport_cycle.index') }}" class="nav-link {{ (request()->is('umrah/transport_cycle')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Transport Cycle</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('umrah_group_view')
                                <li class="nav-item">
                                    <a href="{{ route('group_details.index') }}" class="nav-link {{ (request()->is('umrah/group_details')) ? 'active' : '' }}" onclick="seen_menu('group_details')">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <span id="group_count"></span>
                                        <p>Group List</p>
                                    </a>
                                </li>
                            @endcan
                            @can('booking_confirmation_view')
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $booking_confirmation)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class='nav-icon fas fa-check fa-xs'></i>
                                        <p>
                                            Booking (Service Confirmation)
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('hotel_confirmation_view')
                                            <li class="nav-item">
                                                <a href="{{ route('hotel_confirimation.index') }}" class="nav-link {{ (request()->is('BookingConfirmation/hotel_confirimation')) ? 'active' : '' }}">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Hotel Confirmation</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('transport_confirmation_view')
                                            <li class="nav-item">
                                                <a href="{{ route('transport_confirimation.index') }}" class="nav-link {{ (request()->is('BookingConfirmation/transport_confirimation')) ? 'active' : '' }}">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Transport Confirmation</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                                @can('ziarat_rate_view')
                                    <li class="nav-item">
                                        <a href="{{ route('ziarat_rate.index') }}" class="nav-link {{ request()->is('Application_Setup/Rate_Setup/ziarat_rate')?'active':'' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Ziarat Rate List</p>
                                        </a>
                                    </li>
                                @endcan
                            @endcan
                            @can('ground_services_view')
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $umrah)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class='nav-icon fas fa-check fa-xs'></i>
                                        <p>
                                            Ground Services
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('ground_handle_rate_view')
                                            <li class="nav-item">
                                                <a href="{{ route('ground_handling_rate.index') }}" class="nav-link {{ request()->is('Application_Setup/Rate_Setup/ground_handling_rate')?'active':'' }}">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Ground Handle Rate List</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            @can('umrah_trip_view')
                                <li class="nav-item">
                                    <a href="{{ route('agent_umrah.index') }}" class="nav-link {{ (request()->is('agent_management/agent_umrah')) ? 'active' : '' }}" onclick="seen_menu('agent_umrahs')">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Umrah Trips</p>
                                        <span id="countUmrahTrips"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('umrah_draft.index') }}" class="nav-link {{ (request()->is('agent_management/umrah_draft')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Umrah Draft Trips</p>
                                    </a>
                                </li>
                            @endcan
                            @can('umrah_trip_create')
                                <li class="nav-item">
                                    <a href="{{ route('agent_umrah.create') }}" class="nav-link {{ (request()->is('agent_management/agent_umrah/create')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Create Umrah Trips</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('packages_view')
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $cms)) echo 'menu-open';
                    elseif(in_array(Request::segment(2), $cms)) echo 'menu-open';?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-globe fa-xs"></i>
                            <p>
                                Packages
                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $cms)) echo 'menu-open'; ?>">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-kaaba fa-xs"></i>
                                    <p>
                                        Bookings
                                        <i class="nav-icon right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('customize_packages.index') }}" class="nav-link {{ request()->is('cms/umrah/customize_packages')?'active':'' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Booking List</p>
                                        </a>
                                    </li>
                                    @can('inquries_list_view')
                                        <li class="nav-item">
                                            <a href="{{ route('inquires.index') }}" class="nav-link {{ (request()->is('agent_management/inquires')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Inquiries List</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            @can('umrah_custom_packages_view')
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $cms)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-kaaba fa-xs"></i>
                                        <p>
                                            Umrah
                                            <i class="nav-icon right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('customize_packages.index') }}" class="nav-link {{ request()->is('cms/umrah/customize_packages')?'active':'' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Customize Packages</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('quarantine_packages_view')
                                <li class="nav-item">
                                    <a href="{{ route('quarantine.index') }}" class="nav-link {{ (request()->is('cms/quarantine')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Quarantine Packages</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('accounts_view')
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $accounts)) echo 'menu-open';
                    elseif(in_array(Request::segment(3), $accounts)) echo 'menu-open'; elseif(in_array(Request::segment(1), $sale)) echo 'menu-open';
                    elseif(in_array(Request::segment(2), $agent_disount)) echo 'menu-open';
                    elseif(in_array(Request::segment(3), $account_reports)) echo 'menu-open';?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-key fa-xs"></i>
                            <p>{{ __('accounts.account') }}
                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('accounts_dashboard_view')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.index') }}" class="nav-link {{ (request()->is('Accounts/dashboard')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Accounts Dashboard</p>
                                    </a>
                                </li>
                            @endcan
                            @can('account_setup_view')
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $accounts)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-cog fa-xs"></i>
                                        <p>
                                            Master Account
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('financial_year.index') }}" class="nav-link {{ (request()->is('Accounts/financial_year')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Financial Years</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('root_accounts.index') }}" class="nav-link {{ (request()->is('Accounts/root_accounts')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Root Accounts</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('head_accounts.index') }}" class="nav-link {{ (request()->is('Accounts/head_accounts')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Head Accounts</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('subhead_accounts.index') }}" class="nav-link {{ (request()->is('Accounts/subhead_accounts')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Subhead Accounts</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('trans_accounts.index') }}" class="nav-link {{ (request()->is('Accounts/trans_accounts')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Transaction Accounts</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('vouchers_view')
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $accounts)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-dollar-sign"></i>
                                        <p>
                                            Vouchers
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('rv_view')
                                            <li class="nav-item">
                                                <a href="{{ route('receipt_vouchers.index') }}" class="nav-link {{ (request()->is('Accounts/vouchers/receipt_vouchers')) ? 'active' : '' }}">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Receipt Voucher</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('pv_view')
                                            <li class="nav-item">
                                                <a href="{{ route('payment_vouchers.index') }}" class="nav-link {{ (request()->is('Accounts/vouchers/payment_vouchers')) ? 'active' : '' }}">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Payment Voucher</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('jv_view')
                                            <li class="nav-item">
                                                <a href="{{ route('journal_vouchers.index') }}" class="nav-link {{ (request()->is('Accounts/vouchers/journal_vouchers'))? 'active':'' }}">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Journal Voucher</p>
                                                </a>
                                            </li>
                                        @endcan
                                        {{--<li class="nav-item">--}}
                                        {{--<a href="#" class="nav-link">--}}
                                        {{--<i class="nav-icon fas fa-angle-double-right fa-xs"></i>--}}
                                        {{--<p>Sale Voucher</p>--}}
                                        {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="nav-item">--}}
                                        {{--<a href="#" class="nav-link">--}}
                                        {{--<i class="nav-icon fas fa-angle-double-right fa-xs"></i>--}}
                                        {{--<p>Purchase Voucher</p>--}}
                                        {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="nav-item">--}}
                                        {{--<a href="#" class="nav-link">--}}
                                        {{--<i class="nav-icon fas fa-angle-double-right fa-xs"></i>--}}
                                        {{--<p>Return Voucher</p>--}}
                                        {{--</a>--}}
                                        {{--</li>--}}
                                    </ul>
                                </li>
                            @endcan
                            @can('sale_invoices_view')
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $sale)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class='nav-icon fas fa-ticket-alt fa-xs'></i>
                                        <p>
                                            Invoice
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('Sale') }}" class="nav-link {{ (request()->is('Sale')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>{{ __('sale_invoice.sale_invoice') }}</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Purchase</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('commission_view')
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class='nav-icon fas fa-ticket-alt fa-xs'></i>
                                        <p>
                                            Commission
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link ">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Receiveable</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link ">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Payable</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('general_ledger_view')
                                <li class="nav-item">
                                    <a href="{{ url('Accounts/ledger') }}" class="nav-link {{ (request()->is('Accounts/ledger')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>General Ledger</p>
                                    </a>
                                </li>
                            @endcan
                            @can('wallet_view')
                                <li class="nav-item">
                                    <a href="{{ route('agent_wallet.index') }}" class="nav-link {{ (request()->is('agent_management/agent_wallet')) ? 'active' : '' }}" onclick="seen_menu('agent_wallets')">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Wallet</p>
                                        <span id="countAgentWallet"></span>
                                    </a>
                                </li>
                            @endcan
                            @can('discount_view')
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $agent_disount)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-percent"></i>
                                        <p>
                                            Discount
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('custom_package_discount_view')
                                            <li class="nav-item">
                                                <a href="{{ route('custom_pkg_discount.index') }}" class="nav-link {{ (request()->is('agent_management/custom_pkg_discount')) ? 'active' : '' }}">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Custom Package Discount</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            @can('refund_view')
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $sale)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-undo"></i>
                                        <p>
                                            Refunds
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link {{ (request()->is('Accounts/ledger')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Refunds</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('account_reports_view')
                                <li class="nav-item <?php if(in_array(Request::segment(3), $account_reports)) echo 'menu-open'; ?>">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Account Reports
                                            <i class="nav-icon right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('Accounts/reports/ledger_report') }}" class="nav-link {{ (request()->is('Accounts/reports/ledger_report')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Ledger Reports</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('trail_balance.index') }}" class="nav-link {{ (request()->is('Accounts/reports/trail_balance')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Traial Balance</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('account_day_book.index') }}" class="nav-link {{ (request()->is('Accounts/reports/account_day_book')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Accounts Day Book</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('income_statement.index') }}" class="nav-link {{ (request()->is('Accounts/reports/income_statement')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Income Statement</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('balance_sheet.index') }}" class="nav-link {{ (request()->is('Accounts/reports/balance_sheet')) ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Balance Sheet</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('service_providors.index') }}" class="nav-link {{ (request()->is('Accounts/service_providors')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Service Providers</p>
                                    <span id="countAgentWallet"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @if(Auth::user()->getRoleNames()[0]=='Admin')
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $umrah_reports)) echo 'menu-open'; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-area"></i>
                            <p>
                                {{ __('main.reports') }}
                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link {{ (request()->is('users')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Lead Reports
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('reports/lead_reports/customer_lead_reports') }}" class="nav-link {{ (request()->is('Hr/employee')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Customer Lead Reports</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item <?php if(in_array(Request::segment(3), $umrah_reports)) echo 'menu-open'; ?>">
                                <a href="{{ route('users.index') }}" class="nav-link {{ (request()->is('users')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Umrah Reports
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('arrival_report.index') }}" class="nav-link {{ (request()->is('reports/umrah/arrival_report')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Arrival Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('departure_report.index') }}" class="nav-link {{ (request()->is('reports/umrah/departure_report')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Departure Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('checkin_report.index') }}" class="nav-link {{ (request()->is('reports/umrah/checkin_report')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Checkin Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('checkout_report.index') }}" class="nav-link {{ (request()->is('Hr/employee')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Checkout Report</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
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
                @can('application_setup_view')
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $appication_setup)){ echo 'menu-open'; } elseif(in_array(Request::segment(3), $appication_setup)) echo 'menu-open'; elseif(in_array(Request::segment(2), $appication_setup)) echo 'menu-open';
                    elseif(in_array(Request::segment(3), $user)){ echo 'menu-open'; } elseif(in_array(Request::segment(2), $hr)){ echo 'menu-open'; }
                    elseif(in_array(Request::segment(2), $admin)){ echo 'menu-open'; }
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
                            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $admin)) echo 'menu-open'; ?>">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Admin
                                        <i class="nav-icon fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('agent_management/subadmin') }}" class="nav-link {{ (request()->is('agent_management/subadmin')) ? 'active' : '' }}" onclick="seen_menu('agents')">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Subadmin List</p>
                                            <span id="agent_noti"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('agent_management/agent') }}" class="nav-link {{ (request()->is('agent_management/agent')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Agent List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('go.index') }}" class="nav-link {{ (request()->is('agent_management/go')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Group Organizer</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('agent_commission.index') }}" class="nav-link {{ (request()->is('agent_management/agent_commission')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Agent Commissions</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('orders.index') }}" class="nav-link {{ (request()->is('agent_management/orders')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Booking List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('agent_price.index') }}" class="nav-link {{ (request()->is('agent_management/agent_price')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Price Management</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
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
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
