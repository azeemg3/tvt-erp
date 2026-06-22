<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedSetupAccountPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * Registers the "Setup Account" menu permission together with the granular
     * Client / Vendor CRUD permissions used by the sidebar (@can) and the route
     * permission middleware. They are also granted to the Admin role.
     *
     * @return void
     */
    public function up()
    {
        $guard = config('auth.defaults.guard', 'web');

        // Parent menu permission.
        $setup = $this->makePermission('setup_account', $guard, null, 0, 1);
        $this->makePermission('setup_account_view', $guard, $setup->id, 0, 0);

        // Client permissions.
        $client = $this->makePermission('Client', $guard, null, 1, 1);
        foreach (['client_view', 'client_create', 'client_edit', 'client_delete'] as $name) {
            $this->makePermission($name, $guard, $client->id, 0, 0);
        }

        // Vendor permissions.
        $vendor = $this->makePermission('Vendor', $guard, null, 1, 1);
        foreach (['vendor_view', 'vendor_create', 'vendor_edit', 'vendor_delete'] as $name) {
            $this->makePermission($name, $guard, $vendor->id, 0, 0);
        }

        app()['cache']->forget('spatie.permission.cache');

        $admin = Role::where('name', 'Admin')->where('guard_name', $guard)->first();
        if ($admin) {
            $permissionIds = Permission::whereIn('name', [
                'setup_account', 'setup_account_view',
                'client_view', 'client_create', 'client_edit', 'client_delete',
                'vendor_view', 'vendor_create', 'vendor_edit', 'vendor_delete',
            ])->where('guard_name', $guard)->pluck('id');

            foreach ($permissionIds as $pid) {
                DB::table('role_has_permissions')->updateOrInsert(
                    ['permission_id' => $pid, 'role_id' => $admin->id],
                    ['permission_id' => $pid, 'role_id' => $admin->id]
                );
            }
        }

        app()['cache']->forget('spatie.permission.cache');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $guard = config('auth.defaults.guard', 'web');

        Permission::whereIn('name', [
            'setup_account', 'setup_account_view',
            'client_view', 'client_create', 'client_edit', 'client_delete',
            'vendor_view', 'vendor_create', 'vendor_edit', 'vendor_delete',
        ])->where('guard_name', $guard)->delete();

        app()['cache']->forget('spatie.permission.cache');
    }

    protected function makePermission(string $name, string $guard, ?int $parentId, int $form, int $menu): Permission
    {
        return Permission::firstOrCreate(
            ['name' => $name, 'guard_name' => $guard],
            ['parent_id' => $parentId, 'form' => $form, 'menu' => $menu]
        );
    }
}
