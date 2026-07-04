<?php
// Active-state helpers scoped to the Accounts module.
$accounts=['root_accounts', 'dashboard', 'head_accounts', 'subhead_accounts',
    'trans_accounts', 'payment_vouchers', 'receipt_vouchers','journal_vouchers','ledger',
    'financial_year','service_providors'];
$account_reports=['ledger_report','trail_balance','account_day_book','balance_sheet','income_statement'];
$sale_reports=['simple_sale_register','bsp_sale_report'];
$sale=['Sale'];
$setup_account=['clients','vendors','general-accounts'];
?>
@can('accounts_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $accounts)) echo 'menu-open';
    elseif(in_array(Request::segment(3), $accounts)) echo 'menu-open'; elseif(in_array(Request::segment(1), $sale)) echo 'menu-open';
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
@if(Auth::user()->can('account_reports_view') || Auth::user()->can('sale_invoices_view'))
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $account_reports)) echo 'menu-open';
    elseif(Request::segment(2)=='sale') echo 'menu-open'; elseif(in_array(Request::segment(3), $sale_reports)) echo 'menu-open';?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-area"></i>
            <p>
                {{ __('main.reports') }}
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('account_reports_view')
                <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $account_reports)) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link {{ (request()->is('Accounts/reports/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Account Report
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
            @can('sale_invoices_view')
                <li class="nav-item has-treeview <?php if(Request::segment(2)=='sale' || in_array(Request::segment(3), $sale_reports)) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link {{ (request()->is('reports/sale/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Sale Report
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('simple_sale_register.index') }}" class="nav-link {{ (request()->is('reports/sale/simple_sale_register*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Simple Sale Register</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bsp_sale_report.index') }}" class="nav-link {{ (request()->is('reports/sale/bsp_sale_report*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Bsp Sale Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        </ul>
    </li>
@endif
@can('setup_account_view')
    <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $setup_account)) echo 'menu-open'; ?>">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-address-book fa-xs"></i>
            <p>
                Setup Account
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('client_view')
                <li class="nav-item">
                    <a href="{{ route('clients.index') }}" class="nav-link {{ (request()->is('clients') || request()->is('clients/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Client List</p>
                    </a>
                </li>
            @endcan
            @can('vendor_view')
                <li class="nav-item">
                    <a href="{{ route('vendors.index') }}" class="nav-link {{ (request()->is('vendors') || request()->is('vendors/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Supplier/Vendor List</p>
                    </a>
                </li>
            @endcan
            @can('general_account_view')
                <li class="nav-item">
                    <a href="{{ route('general-accounts.index') }}" class="nav-link {{ (request()->is('general-accounts') || request()->is('general-accounts/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>General Account</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
