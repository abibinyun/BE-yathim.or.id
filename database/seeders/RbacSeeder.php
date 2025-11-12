<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        $config = config('permission');

        if (!$config) {
            $this->command->warn('⚠️  Config file permission.php not found!');
            return;
        }

        DB::beginTransaction();

        try {
            $this->command->info('🔄 Syncing roles & permissions...');

            $definedPermissions = [];

            // 1️⃣ Generate or update permissions per module/action
            foreach ($config['modules'] as $module => $actions) {
                foreach ($actions as $action) {
                    $permName = "{$action}_" . strtolower(str_replace(' ', '_', $module));
                    $definedPermissions[] = $permName;

                    Permission::firstOrCreate(['name' => $permName]);
                }
            }

            // Optional: hapus permission yang tidak ada di config
            $deleted = Permission::whereNotIn('name', $definedPermissions)->delete();
            if ($deleted > 0) {
                $this->command->warn("🧹 Removed {$deleted} outdated permissions.");
            }

            // 2️⃣ Generate roles & assign permissions
            foreach ($config['roles'] as $roleName => $permissions) {
                $role = Role::firstOrCreate(['name' => $roleName]);

                if ($permissions === 'all') {
                    $role->syncPermissions(Permission::all());
                } else {
                    $rolePermissions = [];

                    foreach ($permissions as $module => $actions) {
                        foreach ($actions as $action) {
                            $permName = "{$action}_" . strtolower(str_replace(' ', '_', $module));
                            $rolePermissions[] = $permName;
                        }
                    }

                    $role->syncPermissions($rolePermissions);
                }

                $this->command->info("✅ Role synced: {$roleName}");
            }

            // 3️⃣ Assign super-admin to first user (optional)
            $user = User::first();
            if ($user && !$user->hasRole('super-admin')) {
                $user->assignRole('super-admin');
                $this->command->info("⭐ Assigned 'super-admin' role to first user: {$user->email}");
            }

            DB::commit();
            $this->command->info('🎉 RBAC sync completed successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->command->error('❌ Error while seeding RBAC: ' . $e->getMessage());
        }
    }
}
