<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Ensure Setup Account + Client / Supplier / General Account appear in the
 * Roles permission matrix (parent_id = 0) with View/Create/Edit/Delete
 * children so checking them authorizes the matching sidebar items.
 */
class EnsureSetupAccountPermissionMenus extends Migration
{
    public function up()
    {
        $guard = config('auth.defaults.guard', 'web');

        $setup = $this->ensureParent('setup_account', 'Setup Account', $guard, 0);

        $client = $this->ensureParent('Client', 'Client', $guard, 1);
        $vendor = $this->ensureParent('Vendor', 'Supplier/Vendor', $guard, 1);
        $this->ensureParent('Supplier/Vendor', 'Supplier/Vendor', $guard, 1, $vendor);
        $general = $this->ensureParent('General Account', 'General Account', $guard, 1);

        $this->ensureChildren($setup, ['setup_account_view'], $guard);
        $this->ensureChildren($client, ['client_view', 'client_create', 'client_edit', 'client_delete', 'client_approve', 'client_send', 'client_upload'], $guard);
        $this->ensureChildren($vendor, ['vendor_view', 'vendor_create', 'vendor_edit', 'vendor_delete', 'vendor_approve', 'vendor_send', 'vendor_upload'], $guard);
        $this->ensureChildren($general, ['general_account_view', 'general_account_create', 'general_account_edit', 'general_account_delete', 'general_account_approve', 'general_account_send', 'general_account_upload'], $guard);

        app()['cache']->forget('spatie.permission.cache');

        $names = [
            'setup_account', 'setup_account_view',
            'Client', 'client_view', 'client_create', 'client_edit', 'client_delete',
            'Supplier/Vendor', 'Vendor',
            'vendor_view', 'vendor_create', 'vendor_edit', 'vendor_delete',
            'General Account',
            'general_account_view', 'general_account_create', 'general_account_edit', 'general_account_delete',
        ];

        $admin = Role::where('name', 'Admin')->where('guard_name', $guard)->first();
        if ($admin) {
            $ids = Permission::whereIn('name', $names)->where('guard_name', $guard)->pluck('id');
            foreach ($ids as $pid) {
                DB::table('role_has_permissions')->updateOrInsert(
                    ['permission_id' => $pid, 'role_id' => $admin->id],
                    ['permission_id' => $pid, 'role_id' => $admin->id]
                );
            }
        }

        app()['cache']->forget('spatie.permission.cache');
    }

    public function down()
    {
        // Keep the menus; this seed is additive/idempotent.
    }

    protected function ensureParent(string $lookupName, string $displayName, string $guard, int $form, ?Permission $existing = null): Permission
    {
        $permission = $existing
            ?: Permission::where('guard_name', $guard)->where('name', $lookupName)->first()
            ?: Permission::where('guard_name', $guard)->where('name', $displayName)->first();

        if (! $permission) {
            $permission = Permission::create([
                'name'       => $displayName,
                'guard_name' => $guard,
                'parent_id'  => 0,
                'form'       => $form,
                'menu'       => 1,
            ]);
        } else {
            $permission->name = $displayName;
            $permission->parent_id = 0;
            $permission->form = $form;
            $permission->menu = 1;
            $permission->save();
        }

        return $permission;
    }

    /**
     * @param  string[]  $childNames
     */
    protected function ensureChildren(Permission $parent, array $childNames, string $guard): void
    {
        foreach ($childNames as $name) {
            $child = Permission::where('name', $name)->where('guard_name', $guard)->first();
            if (! $child) {
                Permission::create([
                    'name'       => $name,
                    'guard_name' => $guard,
                    'parent_id'  => $parent->id,
                    'form'       => 0,
                    'menu'       => 0,
                ]);
                continue;
            }

            $child->parent_id = $parent->id;
            $child->form = 0;
            $child->save();
        }
    }
}
