<?php
// Active-state helpers scoped to the Umrah module.
$umrah=['group_details','mofa_list','transport_cycle','ground_handling_rate',
    'transport_reservation','hotel_reservation','ziarat_rate','agent_umrah','umrah_draft'];
$booking_confirmation=['hotel_confirimation','transport_confirimation'];
$accounts=['root_accounts', 'dashboard', 'head_accounts', 'subhead_accounts',
    'trans_accounts', 'payment_vouchers', 'receipt_vouchers','journal_vouchers','ledger',
    'financial_year','agent_wallet','service_providors'];
$cms=['cms','quarantine','customize_packages','tour'];
$umrah_reports=['arrival_report','departure_report','checkin_report','checkout_report'];
?>
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
@if(Auth::user()->isAdmin())
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $umrah_reports)) echo 'menu-open'; ?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-area"></i>
            <p>
                Umrah Reports
                <i class="nav-icon fas fa-angle-left right"></i>
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
                <a href="{{ route('checkout_report.index') }}" class="nav-link {{ (request()->is('reports/umrah/checkout_report')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Checkout Report</p>
                </a>
            </li>
        </ul>
    </li>
@endif
