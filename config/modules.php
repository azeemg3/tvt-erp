<?php

/*
|--------------------------------------------------------------------------
| Business Modules
|--------------------------------------------------------------------------
|
| Central registry that drives the modular navigation:
|   - the "Module Selection" landing page (cards),
|   - which sidebar partial renders for the active module,
|   - and how a request URL is mapped back to its owning module.
|
| Adding a new module is intentionally cheap: register one entry below and
| create its matching sidebar partial under resources/views/layouts/sidebars.
|
*/

return [

    // Slug used when a user has no active module yet and no other hint exists.
    'default' => 'accounts',

    'modules' => [

        'accounts' => [
            'slug'        => 'accounts',
            'label'       => 'Accounts',
            'description' => 'Chart of accounts, vouchers, invoices, ledgers, wallets & financial reports.',
            'icon'        => 'fas fa-wallet',
            'color'       => 'bg-gradient-primary',
            // Permission that grants access to the module (see module permission migration).
            'permission'  => 'accounts_module_view',
            // Route name (preferred) or relative URL used as the module landing screen.
            'dashboard'   => 'dashboard.index',
            'sidebar'     => 'layouts.sidebars.accounts',
            'order'       => 1,
        ],

        'ota' => [
            'slug'        => 'ota',
            'label'       => 'OTA',
            'description' => 'Online Travel Agency: flights, hotels, visas, transport, tours, packages & APIs.',
            'icon'        => 'fas fa-plane-departure',
            'color'       => 'bg-gradient-info',
            'permission'  => 'ota_module_view',
            'dashboard'   => 'home',
            'sidebar'     => 'layouts.sidebars.ota',
            'order'       => 2,
        ],

        'agent' => [
            'slug'        => 'agent',
            'label'       => 'Agent',
            'description' => 'B2B agents & sub-admins: onboarding, bookings, pricing, wallet, commissions & discounts.',
            'icon'        => 'fas fa-user-tie',
            'color'       => 'bg-gradient-warning',
            'permission'  => 'agent_module_view',
            'dashboard'   => 'agent.index',
            'sidebar'     => 'layouts.sidebars.agent',
            'order'       => 3,
        ],

        'umrah' => [
            'slug'        => 'umrah',
            'label'       => 'Umrah',
            'description' => 'Group management, reservations, ground services, trips, packages & Umrah reports.',
            'icon'        => 'fas fa-kaaba',
            'color'       => 'bg-gradient-success',
            'permission'  => 'umrah_module_view',
            'dashboard'   => 'group_details.index',
            'sidebar'     => 'layouts.sidebars.umrah',
            'order'       => 4,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Request → Module detection
    |--------------------------------------------------------------------------
    |
    | Ordered map of request path patterns (Request::is style) to a module slug.
    | The FIRST match wins, so list the most specific patterns first. This keeps
    | the correct sidebar active when a module URL is opened directly (deep link
    | / bookmark / refresh). Ambiguous or shared prefixes (e.g. Application_Setup,
    | agent_management, currencies, Hr, home) are intentionally omitted so the
    | active module is preserved from the session instead of jumping around.
    |
    */
    'detect' => [
        // Umrah (specific first) — including Umrah trip screens that live under
        // the shared agent_management prefix.
        'agent_management/agent_umrah*'        => 'umrah',
        'agent_management/umrah_draft*'        => 'umrah',
        'agent_management/inquires*'           => 'umrah',
        'reports/umrah*'                       => 'umrah',
        'cms/umrah*'                           => 'umrah',
        'umrah*'                               => 'umrah',
        'BookingConfirmation*'                 => 'umrah',

        // Agent (everything else under agent_management)
        'agent_management*'                    => 'agent',

        // Accounts (Sale Report now lives in the Accounts module Reports section)
        'Accounts*'                            => 'accounts',
        'Sale*'                                => 'accounts',
        'reports/sale*'                        => 'accounts',
        'clients*'                             => 'accounts',
        'vendors*'                             => 'accounts',
        'general-accounts*'                    => 'accounts',

        // OTA
        'reports/lead_reports*'                => 'ota',
        'lms*'                                 => 'ota',
        'cms*'                                 => 'ota',
        'api_management*'                      => 'ota',
        'providors*'                           => 'ota',
        'guest*'                               => 'ota',
        'bookings*'                            => 'ota',
    ],

];
