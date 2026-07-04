<?php
// Active-state helpers scoped to the Agent module.
$agent_admin=['agent','subadmin','go','orders','agent_price','agent_commission'];
$agent_wallet=['agent_wallet'];
$agent_disount=['custom_pkg_discount'];
?>
<li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $agent_admin)) echo 'menu-open'; ?>">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users fa-xs"></i>
        <p>
            Agents
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
    </ul>
</li>
<li class="nav-item has-treeview <?php if(in_array(Request::segment(2), ['orders','agent_price'])) echo 'menu-open'; ?>">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-shopping-cart fa-xs"></i>
        <p>
            Bookings &amp; Pricing
            <i class="nav-icon fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
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
@can('wallet_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $agent_wallet)) echo 'menu-open'; ?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-wallet fa-xs"></i>
            <p>
                Wallet
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('agent_wallet.index') }}" class="nav-link {{ (request()->is('agent_management/agent_wallet')) ? 'active' : '' }}" onclick="seen_menu('agent_wallets')">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Agent Wallet</p>
                    <span id="countAgentWallet"></span>
                </a>
            </li>
        </ul>
    </li>
@endcan
@can('commission_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), ['agent_commission'])) echo 'menu-open'; ?>">
        <a href="#" class="nav-link">
            <i class='nav-icon fas fa-hand-holding-usd fa-xs'></i>
            <p>
                Commission
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('agent_commission.index') }}" class="nav-link {{ (request()->is('agent_management/agent_commission')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                    <p>Agent Commissions</p>
                </a>
            </li>
        </ul>
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
