<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Adds the "Agent" business module permission (agent_module_view) that gates
 * access to the dedicated Agent module, and assigns it to the relevant roles.
 *
 * Agent management previously lived under the "Application Setting" menu, so we
 * grant the new module permission to roles that already administer that area
 * or hold an agent-related permission — keeping existing users' access intact.
 */
class SeedAgentModulePermission extends Migration
{
    protected array $implications = [
        'application_setup_view',
        'wallet_view',
        'discount_view',
        'custom_package_discount_view',
        'commission_view',
    ];

    public function up()
    {
        $guard = config('auth.defaults.guard', 'web');

        // Attach under the same "Modules" parent created by the module permission migration.
        $parentId = optional(
            Permission::where('name', 'Modules')->where('guard_name', $guard)->first()
        )->id ?? 0;

        $this->makePermission('agent_module_view', $guard, $parentId, 0, 0);

        app()['cache']->forget('spatie.permission.cache');

        $admin = Role::where('name', 'Admin')->where('guard_name', $guard)->first();
        if ($admin) {
            $this->grant($admin, ['agent_module_view'], $guard);
        }

        foreach (Role::where('guard_name', $guard)->get() as $role) {
            if ($admin && $role->id === $admin->id) {
                continue;
            }

            $existing = DB::table('role_has_permissions')
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where('role_has_permissions.role_id', $role->id)
                ->pluck('permissions.name')
                ->all();

            if (array_intersect($this->implications, $existing)) {
                $this->grant($role, ['agent_module_view'], $guard);
            }
        }

        app()['cache']->forget('spatie.permission.cache');
    }

    public function down()
    {
        $guard = config('auth.defaults.guard', 'web');

        Permission::where('name', 'agent_module_view')->where('guard_name', $guard)->delete();

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
