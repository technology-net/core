<?php

namespace IBoot\Core\Database\Seeders;

use IBoot\Core\app\Models\Plugin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PluginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Plugin::insert([
            [
                'name_package' => 'Dashboard',
                'version' => '',
                'status' => Plugin::STATUS_INSTALLED,
                'scripts' => '',
                'icon' => '<i class="mdi mdi-speedometer"></i>',
                'order' => '1',
                'route' => 'dashboard.index',
                'image' => '',
                'description' => 'Manage dashboard'
            ],
            [
                'name_package' => 'Users',
                'version' => '',
                'status' => Plugin::STATUS_INSTALLED,
                'scripts' => '',
                'icon' => '<i class="mdi mdi-account-group"></i>',
                'order' => '2',
                'route' => 'plugins.index',
                'image' => '',
                'description' => 'Manage users'
            ],
            [
                'name_package' => 'Plugins',
                'version' => '',
                'status' => Plugin::STATUS_INSTALLED,
                'scripts' => '',
                'icon' => '<i class="mdi mdi-arrow-expand-all"></i>',
                'order' => '3',
                'route' => 'plugins.index',
                'image' => '',
                'description' => 'Manage plugins (Active, deactivate, install or uninstall a package)'
            ],
        ]);
    }
}
