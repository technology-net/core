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
                'slug' => 'dashboard.index',
                'icon' => '<i class="mdi mdi-speedometer"></i>',
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'Plugins',
                'parent_id' => null,
                'slug' => 'plugins.index',
                'icon' => '<i class="mdi mdi-arrow-expand-all"></i>',
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);

        $newMenuItem = MenuItem::query()->create([
            'menu_id' => $menu->id,
            'name' => 'Settings',
            'parent_id' => null,
            'slug' => null,
            'icon' => '<i class="mdi mdi-settings"></i>',
            'order' => 3
        ]);

        MenuItem::query()->insert([
            [
                'menu_id' => $menu->id,
                'name' => 'Menus',
                'parent_id' => $newMenuItem->id,
                'slug' => 'settings.menus.index',
                'icon' => null,
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'Users',
                'parent_id' => $newMenuItem->id,
                'slug' => 'settings.users.index',
                'icon' => null,
                'order' => 5,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'System Setting',
                'parent_id' => $newMenuItem->id,
                'slug' => 'settings.system_settings.index',
                'icon' => null,
                'order' => 6,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'Media',
                'parent_id' => $newMenuItem->id,
                'slug' => 'settings.media.index',
                'icon' => null,
                'order' => 7,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
