<?php

namespace IBoot\Core\Database\Seeders;

use Carbon\Carbon;
use IBoot\Core\App\Models\Menu;
use IBoot\Core\App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        MenuItem::query()->truncate();
        Menu::query()->delete();
        $now = Carbon::now();
        $menu = Menu::query()->create([
            'menu_type' => Menu::TYPE_IS_SIDE_BAR,
        ]);
        MenuItem::query()->insert([
            [
                'menu_id' => $menu->id,
                'name' => 'Dashboard',
                'parent_id' => null,
                'url' => 'dashboard.index',
                'icon' => 'fas fa-tachometer-alt',
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'Plugins',
                'parent_id' => null,
                'url' => 'plugins.index',
                'icon' => 'fas fa-plug',
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'Media',
                'parent_id' => null,
                'url' => 'media.index',
                'icon' => 'far fa-image',
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);

        $newMenuItem = MenuItem::query()->create([
            'menu_id' => $menu->id,
            'name' => 'Settings',
            'parent_id' => null,
            'url' => null,
            'icon' => 'fas fa-cogs',
            'order' => 4
        ]);

        MenuItem::query()->insert([
            [
                'menu_id' => $menu->id,
                'name' => 'Menus',
                'parent_id' => $newMenuItem->id,
                'url' => 'settings.menus.index',
                'icon' => null,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'Users',
                'parent_id' => $newMenuItem->id,
                'url' => 'settings.users.index',
                'icon' => null,
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'System Setting',
                'parent_id' => $newMenuItem->id,
                'url' => 'settings.system_settings.index',
                'icon' => null,
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        $rolePermissions = MenuItem::query()->create([
            'menu_id' => $menu->id,
            'name' => 'Roles and Permissions',
            'parent_id' => null,
            'url' => null,
            'icon' => 'fas fa-user-shield',
            'order' => 5,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        MenuItem::query()->insert([
            [
                'menu_id' => $menu->id,
                'name' => 'Roles',
                'parent_id' => $rolePermissions->id,
                'url' => 'roles.index',
                'icon' => null,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'Permissions',
                'parent_id' => $rolePermissions->id,
                'url' => 'permissions.index',
                'icon' => null,
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
