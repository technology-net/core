<?php

namespace IBoot\Core\Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $baseText = ['delete', 'edit', 'create', 'view'];
        $screens = ['categories', 'posts', 'pages', 'users', 'permissions', 'roles', 'menus', 'system settings'];
        $permissions = [];
        foreach ($screens as $screen) {
            foreach ($baseText as $text) {
                $permissionName = $text . ' ' . $screen;
                $permissions[] = [
                    'name' => $permissionName,
                    'group_name' => $screen,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        Permission::query()->delete();
        Permission::query()->insert($permissions);
    }
}
