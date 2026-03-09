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
    <a href="<?php echo e(url('home')); ?>" class="brand-link elevation-4 navbar-info" style="padding: 12px !important;">
        
        <span class="brand-text font-weight-light">YourOwn-Trips</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo e(URL::asset('public/dist/img/user2-160x160.jpg')); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo e(auth()->user()->name); ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_view')): ?>
                    <li class="nav-item has-treeview">
                        <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e((request()->is('home')) ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p> Dashboard </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(Auth::user()->getRoleNames()[0]=='Providor' || Auth::user()->getRoleNames()[0]=='Admin'): ?>
                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $providors)) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link">
                        <i class='nav-icon fas fa-chart-bar fa-xs'></i>
                        <p>
                            Providors
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php
                    $sp=\App\Helpers\CommonHelper::sp_access();
                    if($sp['result']!==null){
                        $sp=explode(',',$sp['result']['product_includes']);
                    }
                    ?>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(url('providors')); ?>" class="nav-link <?php echo e((request()->is('providors')) ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <?php if(in_array(1,$sp)): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(url('providors')); ?>" class="nav-link <?php echo e((request()->is('')) ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Flight Providor</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(in_array('2',$sp)): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('hotel_providor.index')); ?>" class="nav-link <?php echo e((request()->is('providors/hotel_providor')) ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Hotel Providor</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(in_array('3',$sp)): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('visa_providor.index')); ?>" class="nav-link <?php echo e((request()->is('providors/visa_providor')) ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Visa Providor</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(in_array('4',$sp)): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('transport_providor.index')); ?>" class="nav-link <?php echo e((request()->is('providors/transport_providor')) ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Transport Providor</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(in_array(5,$sp)): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(url('providors')); ?>" class="nav-link <?php echo e((request()->is('')) ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Insurance Providor</p>
                            </a>
                        </li>
                        <?php endif; ?>
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
                                    <a href="<?php echo e(url('providors/accounts/account_statement')); ?>" class="nav-link <?php echo e((request()->is('providors/accounts/account_statement')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>General Ledger Statement</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('statistics_view')): ?>
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
                                <a href="<?php echo e(route('statistic.index')); ?>" class="nav-link <?php echo e((request()->is('statistics/statistic')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Statistics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('statistics/admin_statistic')); ?>" class="nav-link <?php echo e((request()->is('statistics/admin_statistic')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Admin Statistics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('statistics/subadmin_statistic')); ?>" class="nav-link <?php echo e((request()->is('statistics/subadmin_statistic')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Sub Admin Statistics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('statistics/agent_statistic')); ?>" class="nav-link <?php echo e((request()->is('statistics/agent_statistic')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Agent Statistics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('statistics/agent_statistic')); ?>" class="nav-link <?php echo e((request()->is('statistics')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Group Organizer</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lms_view')): ?>
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $lead)) echo 'menu-open'; ?>">
                        <a href="#" class="nav-link">
                            <i class='nav-icon fas fa-graduation-cap fa-xs'></i>
                            <p>
                                <?php echo e(__('lms.lms')); ?>

                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('lead.index')); ?>" class="nav-link <?php echo e((request()->is('lms/lead')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p><?php echo e(__('lms.dashboard')); ?></p>
                                </a>
                            </li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead_create')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('lead.create')); ?>" class="nav-link <?php echo e((request()->is('lms/lead/create')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p><?php echo e(__('lms.create_lead')); ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pending_leads_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(url('lms/pending_leads')); ?>" class="nav-link <?php echo e((request()->is('lms/pending_leads')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p><?php echo e(__('lms.pending_leads')); ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('my_leads_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(url('lms/my_leads')); ?>" class="nav-link <?php echo e((request()->is('lms/my_leads')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p><?php echo e(__('lms.my_lead')); ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('all_leads_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(url('lms/all_leads')); ?>" class="nav-link <?php echo e((request()->is('lms/all_leads')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p><?php echo e(__('lms.all_lead')); ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('visa_view')): ?>
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $visa)) echo 'menu-open' ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-globe"></i>
                            <p>
                                Visa
                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('visa_rate_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('visa_rate.index')); ?>" class="nav-link <?php echo e(request()->is('Application_Setup/Rate_Setup/visa_rate')?'active':''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Visa Rate</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('flight_view')): ?>
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $flight)) echo 'menu-open';?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-plane fa-xs"></i>
                            <p>
                                Flight
                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ticket_source_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('ticket_source.index')); ?>" class="nav-link <?php echo e(request()->is('Application_Setup/ticket_source')? 'active':''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Ticket Source</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('airline_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('airlines.index')); ?>" class="nav-link <?php echo e(request()->is('Application_Setup/airlines')?'active':''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Airlines</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link <?php echo e(request()->is('api_management/flight')?'active':''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>All Bookings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('guest_users.index')); ?>" class="nav-link <?php echo e((request()->is('guest')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Service Providors</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hotel_view')): ?>
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
                                <a href="<?php echo e(route('hotel.index')); ?>" class="nav-link <?php echo e(request()->is('Application_Setup/hotel')?'active':''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Hotels</p>
                                </a>
                            </li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('room_type_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('room_types.index')); ?>" class="nav-link <?php echo e(request()->is('Application_Setup/room_types')?'active':''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Room Types</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hotel_rate_list_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('hotel_rate.index')); ?>" class="nav-link <?php echo e(request()->is('Application_Setup/Rate_Setup/hotel_rate')?'active':''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Hotel Rate List</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('guest_users.index')); ?>" class="nav-link <?php echo e((request()->is('guest')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Service Providors</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transport_view')): ?>
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
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transport_rate_list_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('transport_rate.index')); ?>" class="nav-link <?php echo e(request()->is('Application_Setup/Rate_Setup/transport_rate')?'active':''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Transport Rate List</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tour_view')): ?>
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
                                <a href="<?php echo e(route('tour.index')); ?>" class="nav-link <?php echo e(request()->is('cms/tours/tour')?'active':''); ?>

                                <?php echo e(request()->is('cms/tours/tour/create')?'active':''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Tour</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('umrah_view')): ?>
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $umrah)) echo 'menu-open';
                    elseif(in_array(Request::segment(2), $booking_confirmation)) echo 'menu-open'; if(in_array(Request::segment(3), $booking_confirmation)) echo 'menu-open';
                    elseif(in_array(Request::segment(3), $umrah)) echo 'menu-open';?>">
                        <a href="#" class="nav-link">
                            <i class='nav-icon fas fa-kaaba fa-xs'></i>
                            <span id="umrah_count"></span>
                            <p>
                                <?php echo e(__('umrah_mng.umrah_management')); ?>

                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reservation_view')): ?>
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
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hotel_reservation_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('hotel_reservation.index')); ?>" class="nav-link <?php echo e((request()->is('umrah/hotel_reservation')) ? 'active' : ''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Hotel Reservations</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transport_reservation_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('transport_reservation.index')); ?>" class="nav-link <?php echo e((request()->is('umrah/transport_reservation')) ? 'active' : ''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Transport Reservation</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('transport_cycle.index')); ?>" class="nav-link <?php echo e((request()->is('umrah/transport_cycle')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Transport Cycle</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('umrah_group_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('group_details.index')); ?>" class="nav-link <?php echo e((request()->is('umrah/group_details')) ? 'active' : ''); ?>" onclick="seen_menu('group_details')">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <span id="group_count"></span>
                                        <p>Group List</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_confirmation_view')): ?>
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $booking_confirmation)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class='nav-icon fas fa-check fa-xs'></i>
                                        <p>
                                            Booking (Service Confirmation)
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hotel_confirmation_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('hotel_confirimation.index')); ?>" class="nav-link <?php echo e((request()->is('BookingConfirmation/hotel_confirimation')) ? 'active' : ''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Hotel Confirmation</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transport_confirmation_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('transport_confirimation.index')); ?>" class="nav-link <?php echo e((request()->is('BookingConfirmation/transport_confirimation')) ? 'active' : ''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Transport Confirmation</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ziarat_rate_view')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('ziarat_rate.index')); ?>" class="nav-link <?php echo e(request()->is('Application_Setup/Rate_Setup/ziarat_rate')?'active':''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Ziarat Rate List</p>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ground_services_view')): ?>
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $umrah)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class='nav-icon fas fa-check fa-xs'></i>
                                        <p>
                                            Ground Services
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ground_handle_rate_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('ground_handling_rate.index')); ?>" class="nav-link <?php echo e(request()->is('Application_Setup/Rate_Setup/ground_handling_rate')?'active':''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Ground Handle Rate List</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('umrah_trip_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('agent_umrah.index')); ?>" class="nav-link <?php echo e((request()->is('agent_management/agent_umrah')) ? 'active' : ''); ?>" onclick="seen_menu('agent_umrahs')">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Umrah Trips</p>
                                        <span id="countUmrahTrips"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('umrah_draft.index')); ?>" class="nav-link <?php echo e((request()->is('agent_management/umrah_draft')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Umrah Draft Trips</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('umrah_trip_create')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('agent_umrah.create')); ?>" class="nav-link <?php echo e((request()->is('agent_management/agent_umrah/create')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Create Umrah Trips</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('packages_view')): ?>
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
                                        <a href="<?php echo e(route('customize_packages.index')); ?>" class="nav-link <?php echo e(request()->is('cms/umrah/customize_packages')?'active':''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Booking List</p>
                                        </a>
                                    </li>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inquries_list_view')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('inquires.index')); ?>" class="nav-link <?php echo e((request()->is('agent_management/inquires')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Inquiries List</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('umrah_custom_packages_view')): ?>
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
                                            <a href="<?php echo e(route('customize_packages.index')); ?>" class="nav-link <?php echo e(request()->is('cms/umrah/customize_packages')?'active':''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Customize Packages</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('quarantine_packages_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('quarantine.index')); ?>" class="nav-link <?php echo e((request()->is('cms/quarantine')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Quarantine Packages</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accounts_view')): ?>
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $accounts)) echo 'menu-open';
                    elseif(in_array(Request::segment(3), $accounts)) echo 'menu-open'; elseif(in_array(Request::segment(1), $sale)) echo 'menu-open';
                    elseif(in_array(Request::segment(2), $agent_disount)) echo 'menu-open';
                    elseif(in_array(Request::segment(3), $account_reports)) echo 'menu-open';?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-key fa-xs"></i>
                            <p><?php echo e(__('accounts.account')); ?>

                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('accounts_dashboard_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('dashboard.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/dashboard')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Accounts Dashboard</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account_setup_view')): ?>
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
                                            <a href="<?php echo e(route('financial_year.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/financial_year')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Financial Years</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('root_accounts.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/root_accounts')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Root Accounts</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('head_accounts.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/head_accounts')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Head Accounts</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('subhead_accounts.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/subhead_accounts')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Subhead Accounts</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('trans_accounts.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/trans_accounts')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Transaction Accounts</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vouchers_view')): ?>
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $accounts)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-dollar-sign"></i>
                                        <p>
                                            Vouchers
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rv_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('receipt_vouchers.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/vouchers/receipt_vouchers')) ? 'active' : ''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Receipt Voucher</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pv_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('payment_vouchers.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/vouchers/payment_vouchers')) ? 'active' : ''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Payment Voucher</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('jv_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('journal_vouchers.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/vouchers/journal_vouchers'))? 'active':''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Journal Voucher</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale_invoices_view')): ?>
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
                                            <a href="<?php echo e(url('Sale')); ?>" class="nav-link <?php echo e((request()->is('Sale')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p><?php echo e(__('sale_invoice.sale_invoice')); ?></p>
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
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('commission_view')): ?>
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
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('general_ledger_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(url('Accounts/ledger')); ?>" class="nav-link <?php echo e((request()->is('Accounts/ledger')) ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>General Ledger</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('wallet_view')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('agent_wallet.index')); ?>" class="nav-link <?php echo e((request()->is('agent_management/agent_wallet')) ? 'active' : ''); ?>" onclick="seen_menu('agent_wallets')">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Wallet</p>
                                        <span id="countAgentWallet"></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('discount_view')): ?>
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $agent_disount)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-percent"></i>
                                        <p>
                                            Discount
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('custom_package_discount_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('custom_pkg_discount.index')); ?>" class="nav-link <?php echo e((request()->is('agent_management/custom_pkg_discount')) ? 'active' : ''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Custom Package Discount</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('refund_view')): ?>
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
                                            <a href="#" class="nav-link <?php echo e((request()->is('Accounts/ledger')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Refunds</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account_reports_view')): ?>
                                <li class="nav-item <?php if(in_array(Request::segment(3), $account_reports)) echo 'menu-open'; ?>">
                                    <a href="<?php echo e(route('users.index')); ?>" class="nav-link">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Account Reports
                                            <i class="nav-icon right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo e(url('Accounts/reports/ledger_report')); ?>" class="nav-link <?php echo e((request()->is('Accounts/reports/ledger_report')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Ledger Reports</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('trail_balance.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/reports/trail_balance')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Traial Balance</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('account_day_book.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/reports/account_day_book')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Accounts Day Book</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('income_statement.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/reports/income_statement')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Income Statement</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('balance_sheet.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/reports/balance_sheet')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Balance Sheet</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('service_providors.index')); ?>" class="nav-link <?php echo e((request()->is('Accounts/service_providors')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Service Providers</p>
                                    <span id="countAgentWallet"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(Auth::user()->getRoleNames()[0]=='Admin'): ?>
                    <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $umrah_reports)) echo 'menu-open'; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-area"></i>
                            <p>
                                <?php echo e(__('main.reports')); ?>

                                <i class="nav-icon fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e((request()->is('users')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Lead Reports
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(url('reports/lead_reports/customer_lead_reports')); ?>" class="nav-link <?php echo e((request()->is('Hr/employee')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Customer Lead Reports</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item <?php if(in_array(Request::segment(3), $umrah_reports)) echo 'menu-open'; ?>">
                                <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e((request()->is('users')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Umrah Reports
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('arrival_report.index')); ?>" class="nav-link <?php echo e((request()->is('reports/umrah/arrival_report')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Arrival Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('departure_report.index')); ?>" class="nav-link <?php echo e((request()->is('reports/umrah/departure_report')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Departure Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('checkin_report.index')); ?>" class="nav-link <?php echo e((request()->is('reports/umrah/checkin_report')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Checkin Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('checkout_report.index')); ?>" class="nav-link <?php echo e((request()->is('Hr/employee')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Checkout Report</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('guest_user_view')): ?>
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
                                <a href="<?php echo e(url('guest')); ?>" class="nav-link <?php echo e((request()->is('guest')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('guest_users.index')); ?>" class="nav-link <?php echo e((request()->is('guest/guest_users')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>User List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('guest_users.index')); ?>" class="nav-link <?php echo e((request()->is('guest')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Service Providors</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('application_setup_view')): ?>
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
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('email_template_view')): ?>
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $sale)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class='nav-icon fas fa-envelope fa-xs'></i>
                                        <p>
                                            Email Template Management
                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $user)) echo 'menu-open'; ?>">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        <?php echo e(__('user_management.user_management')); ?>

                                        <i class="nav-icon fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e((request()->is('Application_Setup/user_management/users')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>User List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('users.create')); ?>" class="nav-link <?php echo e((request()->is('Application_Setup/user_management/users/create')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Create New User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('roles.index')); ?>" class="nav-link <?php echo e((request()->is('Application_Setup/user_management/roles')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Roles</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('permission.index')); ?>" class="nav-link <?php echo e((request()->is('Application_Setup/user_management/permission')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Permissions</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hr_view')): ?>
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $hr)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-user-cog"></i>
                                        <p>
                                            <?php echo e(__('main.hr')); ?>

                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hr_setup_view')): ?>
                                            <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $hr)) echo 'menu-open'; ?>">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fa-cog fa-xs"></i>
                                                    <p>
                                                        HR Setup
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('designation_view')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('designation.index')); ?>" class="nav-link <?php echo e((request()->is('Hr/designation')) ? 'active' : ''); ?>">
                                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                                <p>Designation</p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_view')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('department.index')); ?>" class="nav-link <?php echo e((request()->is('Hr/department')) ? 'active' : ''); ?>">
                                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                                <p>Department</p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_details_view')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('employee.index')); ?>" class="nav-link <?php echo e((request()->is('Hr/employee')) ? 'active' : ''); ?>">
                                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                    <p>Employee Details</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
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
                                        <a href="<?php echo e(url('agent_management/subadmin')); ?>" class="nav-link <?php echo e((request()->is('agent_management/subadmin')) ? 'active' : ''); ?>" onclick="seen_menu('agents')">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Subadmin List</p>
                                            <span id="agent_noti"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(url('agent_management/agent')); ?>" class="nav-link <?php echo e((request()->is('agent_management/agent')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Agent List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('go.index')); ?>" class="nav-link <?php echo e((request()->is('agent_management/go')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Group Organizer</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('agent_commission.index')); ?>" class="nav-link <?php echo e((request()->is('agent_management/agent_commission')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Agent Commissions</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('orders.index')); ?>" class="nav-link <?php echo e((request()->is('agent_management/orders')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Booking List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('agent_price.index')); ?>" class="nav-link <?php echo e((request()->is('agent_management/agent_price')) ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Price Management</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('business_setup_view')): ?>
                                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $bus_setup)) echo 'menu-open'; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-business-time"></i>
                                        <p>
                                            <?php echo e(__('main.business_setup')); ?>

                                            <i class="nav-icon fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('company_setup.create')); ?>" class="nav-link <?php echo e((request()->is('company_setup/create')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Company Setup</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('branches.index')); ?>" class="nav-link <?php echo e((request()->is('branches')) ? 'active' : ''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Branches</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('currencies.index')); ?>" class="nav-link <?php echo e(request()->is('currencies')?'active':''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Currency</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('currency_history')); ?>" class="nav-link <?php echo e(request()->is('currency_history')?'active':''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Currency Rate History</p>
                                </a>
                            </li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('location_setup_view')): ?>
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
                                            <a href="<?php echo e(route('continents.index')); ?>" class="nav-link <?php echo e(request()->is('continents')?'active':''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Continents</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('countries.index')); ?>" class="nav-link <?php echo e(request()->is('countries')?'active':''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Countries</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('province.index')); ?>" class="nav-link <?php echo e(request()->is('province')?'active':''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Province/State</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('division.index')); ?>" class="nav-link <?php echo e(request()->is('division')?'active':''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Divisions</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('district.index')); ?>" class="nav-link <?php echo e(request()->is('district')?'active':''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>District</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('cities.index')); ?>" class="nav-link <?php echo e(request()->is('cities')?'active':''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Cities</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('areas.index')); ?>" class="nav-link <?php echo e(request()->is('areas')?'active':''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Areas</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('mosques.index')); ?>" class="nav-link <?php echo e(request()->is('mosques')?'active':''); ?>">
                                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                                <p>Mosques</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('api_management_view')): ?>
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
                                <a href="<?php echo e(url('api_management')); ?>" class="nav-link <?php echo e((request()->is('api_management')) ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>Api Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('currency_api')); ?>" class="nav-link <?php echo e(request()->is('currency_api')?'active':''); ?>">
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
                                        <a href="#" class="nav-link <?php echo e(request()->is('api_management/flight')?'active':''); ?>">
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
                                        <a href="<?php echo e(url('api_management/flight')); ?>" class="nav-link <?php echo e(request()->is('api_management/flight')?'active':''); ?>">
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
                                        <a href="<?php echo e(url('api_management/flight')); ?>" class="nav-link <?php echo e(request()->is('api_management/flight')?'active':''); ?>">
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
                                        <a href="<?php echo e(url('api_management/flight')); ?>" class="nav-link <?php echo e(request()->is('api_management/flight')?'active':''); ?>">
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
                                        <a href="<?php echo e(url('api_management/flight')); ?>" class="nav-link <?php echo e(request()->is('api_management/flight')?'active':''); ?>">
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
                                        <a href="<?php echo e(url('api_management/flight')); ?>" class="nav-link <?php echo e(request()->is('api_management/flight')?'active':''); ?>">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>All</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/layouts/aside.blade.php ENDPATH**/ ?>