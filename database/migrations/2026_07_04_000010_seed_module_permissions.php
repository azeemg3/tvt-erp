<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Seeds the top-level "business module" permissions that gate access to the
 * modular navigation (Accounts / OTA / Umrah) and assigns them to roles.
 *
 * To avoid locking existing (non-admin) roles out of features they already
 * use, each module permission is also granted to any role that already holds
 * a representative permission of that module.
 */
class SeedModulePermissions extends Migration
{
    /**
     * Module view-permission => list of existing permissions that imply the module.
     */
    protected array $moduleImplications = [
        'accounts_module_view' => ['accounts_view', 'setup_account_view'],
        'ota_module_view'      => [
            'sale_invoices_view', 'flight_view', 'hotel_view', 'visa_view',
            'transport_view', 'tour_view', 'packages_view', 'api_management_view',
            'guest_user_view',
        ],
        'umrah_module_view'    => ['umrah_view', 'packages_view'],
    ];

    public function up()
    {
        $guard = config('auth.defaults.guard', 'web');

        // Parent menu node so the permissions group nicely in the Roles UI.
        $parent = $this->makePermission('Modules', $guard, 0, 0, 1);

        foreach (array_keys($this->moduleImplications) as $name) {
            $this->makePermission($name, $guard, $parent->id, 0, 0);
        }

        app()['cache']->forget('spatie.permission.cache');

        // Admin gets every module.
        $admin = Role::where('name', 'Admin')->where('guard_name', $guard)->first();
        if ($admin) {
            $this->grant($admin, array_keys($this->moduleImplications), $guard);
        }

        // Derive module access for every other role from what it can already do.
        foreach (Role::where('guard_name', $guard)->get() as $role) {
            if ($admin && $role->id === $admin->id) {
                continue;
            }

            $existing = DB::table('role_has_permissions')
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where('role_has_permissions.role_id', $role->id)
                ->pluck('permissions.name')
                ->all();

            $toGrant = [];
            foreach ($this->moduleImplications as $moduleView => $implies) {
                if (array_intersect($implies, $existing)) {
                    $toGrant[] = $moduleView;
                }
            }

            if ($toGrant) {
                $this->grant($role, $toGrant, $guard);
            }
        }

        app()['cache']->forget('spatie.permission.cache');
    }

    public function down()
    {
        $guard = config('auth.defaults.guard', 'web');

        Permission::whereIn('name', array_merge(['Modules'], array_keys($this->moduleImplications)))
            ->where('guard_name', $guard)
            ->delete();

        app()['cache']->forget('spatie.permission.cache');
    }

    protected function grant(Role $role, array $permissionNames, string $guard): void
    {
        $permissionIds = Permission::whereIn('name', $permissionNames)
            ->where('guard_name', $guard)
            ->pluck('id');

        foreach ($permissionIds as $pid) {
            DB::table('role_has_permissions')->updateOrInsert(
                ['permission_id' => $pid, 'role_id' => $role->id],
                ['permission_id' => $pid, 'role_id' => $role->id]
            );
        }
    }

    protected function makePermission(string $name, string $guard, ?int $parentId, int $form, int $menu): Permission
    {
        return Permission::firstOrCreate(
            ['name' => $name, 'guard_name' => $guard],
            ['parent_id' => $parentId, 'form' => $form, 'menu' => $menu]
        );
    }
}
