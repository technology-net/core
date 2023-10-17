<?php

namespace IBoot\Core\Database\Seeders;

use Carbon\Carbon;
use IBoot\Core\app\Models\Menu;
use IBoot\Core\app\Models\MenuItem;
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
                'name' => 'Platform',
                'parent_id' => null,
                'slug' => null,
                'icon' => '<i class="mdi mdi-account-group"></i>',
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'Users',
                'parent_id' => 2,
                'slug' => 'users.index',
                'icon' => null,
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'menu_id' => $menu->id,
                'name' => 'Plugins',
                'parent_id' => null,
                'slug' => 'plugins.index',
                'icon' => '<i class="mdi mdi-arrow-expand-all"></i>',
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
