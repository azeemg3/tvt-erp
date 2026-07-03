<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedGeneralAccountPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $guard = config('auth.defaults.guard', 'web');

        $generalAccount = $this->makePermission('General Account', $guard, null, 1, 1);
        foreach (['general_account_view', 'general_account_create', 'general_account_edit', 'general_account_delete'] as $name) {
            $this->makePermission($name, $guard, $generalAccount->id, 0, 0);
        }

        app()['cache']->forget('spatie.permission.cache');

        $admin = Role::where('name', 'Admin')->where('guard_name', $guard)->first();
        if ($admin) {
            $permissionIds = Permission::whereIn('name', [
                'general_account_view', 'general_account_create', 'general_account_edit', 'general_account_delete',
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
            'general_account_view', 'general_account_create', 'general_account_edit', 'general_account_delete',
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
