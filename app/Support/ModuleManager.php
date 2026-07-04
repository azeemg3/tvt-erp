<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Central access point for the modular navigation.
 *
 * Reads the module registry from config/modules.php and resolves, for the
 * current user/request:
 *   - which modules they can access (permission gated),
 *   - which module is currently "active" (session driven, URL aware),
 *   - and where each module's dashboard lives.
 */
class ModuleManager
{
    /** Session key holding the slug of the currently selected module. */
    public const SESSION_KEY = 'active_module';

    /**
     * All registered modules, ordered by their "order" key.
     *
     * @return array<string, array>
     */
    public static function all(): array
    {
        $modules = config('modules.modules', []);

        uasort($modules, function ($a, $b) {
            return ($a['order'] ?? 99) <=> ($b['order'] ?? 99);
        });

        return $modules;
    }

    /**
     * Fetch a single module definition by slug.
     */
    public static function find(?string $slug): ?array
    {
        if (! $slug) {
            return null;
        }

        return config('modules.modules.' . $slug);
    }

    /**
     * Whether the given user may access the module.
     *
     * Admins can access everything; otherwise the module's `permission`
     * gate must be satisfied.
     */
    public static function canAccess(string $slug, $user = null): bool
    {
        $module = static::find($slug);

        if (! $module) {
            return false;
        }

        $user = $user ?: Auth::user();

        if (! $user) {
            return false;
        }

        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return true;
        }

        $permission = $module['permission'] ?? null;

        if (! $permission) {
            return true;
        }

        return $user->can($permission);
    }

    /**
     * Modules the given user can access, preserving registry order.
     *
     * @return array<string, array>
     */
    public static function accessible($user = null): array
    {
        $user = $user ?: Auth::user();

        return array_filter(static::all(), function ($module) use ($user) {
            return static::canAccess($module['slug'], $user);
        });
    }

    /**
     * Persist the active module for the session.
     */
    public static function setActive(string $slug): void
    {
        session([static::SESSION_KEY => $slug]);
    }

    /**
     * Resolve the slug of the active module for the current user.
     *
     * Falls back to the first accessible module (or the configured default)
     * when nothing valid is stored in the session.
     */
    public static function activeSlug($user = null): ?string
    {
        $user = $user ?: Auth::user();

        if (! $user) {
            return null;
        }

        $slug = session(static::SESSION_KEY);

        if ($slug && static::canAccess($slug, $user)) {
            return $slug;
        }

        $accessible = static::accessible($user);

        if (! empty($accessible)) {
            $default = config('modules.default');

            if ($default && isset($accessible[$default])) {
                return $default;
            }

            return array_key_first($accessible);
        }

        return null;
    }

    /**
     * The active module definition for the current user.
     */
    public static function active($user = null): ?array
    {
        return static::find(static::activeSlug($user));
    }

    /**
     * Map the incoming request to its owning module slug (or null when the
     * path is shared/ambiguous and should not force a module switch).
     */
    public static function detectFromRequest(Request $request): ?string
    {
        foreach ((array) config('modules.detect', []) as $pattern => $slug) {
            if ($request->is($pattern)) {
                return $slug;
            }
        }

        return null;
    }

    /**
     * Resolve the landing URL for a module's dashboard. Supports either a
     * named route or a relative URL in the module's `dashboard` key.
     */
    public static function dashboardUrl(string $slug): string
    {
        $module = static::find($slug);

        $target = $module['dashboard'] ?? null;

        if (! $target) {
            return url('home');
        }

        if (Route::has($target)) {
            return route($target);
        }

        return url($target);
    }
}
