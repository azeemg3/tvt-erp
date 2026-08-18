<?php

namespace App\Http\Controllers;

use App\Support\DashboardHub;
use App\Support\ModuleManager;

/**
 * Drives the module selection landing page and module switching.
 */
class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Module selection dashboard shown as cards/tiles.
     */
    public function index()
    {
        $moduleTiles = DashboardHub::moduleTiles();

        return view('modules.index', compact('moduleTiles'));
    }

    /**
     * Select a module, remember it for the session, and jump to its dashboard.
     */
    public function select($slug)
    {
        if (! ModuleManager::canAccess($slug)) {
            abort(403, 'You do not have access to this module.');
        }

        ModuleManager::setActive($slug);

        return redirect(ModuleManager::dashboardUrl($slug));
    }
}
