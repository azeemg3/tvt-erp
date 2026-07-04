<?php

namespace App\Http\Middleware;

use App\Support\ModuleManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

/**
 * Keeps the "active module" in sync with the request and shares the resolved
 * module context with every view (so the sidebar dispatcher and navbar can
 * render the correct, module-scoped navigation).
 */
class SetActiveModule
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // If the URL clearly belongs to a module, make it the active one so
            // deep links / refreshes always show the matching sidebar.
            $detected = ModuleManager::detectFromRequest($request);

            if ($detected && ModuleManager::canAccess($detected)) {
                ModuleManager::setActive($detected);
            }

            $activeSlug = ModuleManager::activeSlug();

            View::share('activeModuleSlug', $activeSlug);
            View::share('activeModule', $activeSlug ? ModuleManager::find($activeSlug) : null);
            View::share('accessibleModules', ModuleManager::accessible());
        }

        return $next($request);
    }
}
