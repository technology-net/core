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
                'version' => null,
                'composer_name' => null,
                'status' => Plugin::STATUS_INSTALLED,
                'is_default' => Plugin::IS_DEFAULT,
                'is_parent' => Plugin::IS_NOT_PARENT,
                'child_of' => null,
                'scripts' => null,
                'icon' => '<i class="mdi mdi-speedometer"></i>',
                'order' => 1,
                'route' => 'dashboard.index',
                'image' => 'core/images/plugins/dashboard.png',
                'description' => 'Manage dashboard'
            ],
            [
                'name_package' => 'Platform',
                'version' => null,
                'composer_name' => 'iboot/platform',
                'status' => Plugin::STATUS_INSTALLED,
                'is_default' => Plugin::IS_NOT_DEFAULT,
                'is_parent' => Plugin::IS_PARENT,
                'child_of' => null,
                'scripts' => null,
                'icon' => '<i class="mdi mdi-account-group"></i>',
                'order' => 2,
                'route' => null,
                'image' => 'core/images/plugins/platform.png',
                'description' => 'Manage platform administration'
            ],
            [
                'name_package' => 'Plugins',
                'version' => null,
                'composer_name' => null,
                'status' => Plugin::STATUS_INSTALLED,
                'is_default' => Plugin::IS_DEFAULT,
                'is_parent' => Plugin::IS_NOT_PARENT,
                'child_of' => null,
                'scripts' => null,
                'icon' => '<i class="mdi mdi-arrow-expand-all"></i>',
                'order' => 3,
                'route' => 'plugins.index',
                'image' => 'core/images/plugins/plugin.png',
                'description' => 'Manage plugins (Active, deactivate, install or uninstall a package)'
            ],
            [
                'name_package' => 'Users',
                'version' => null,
                'composer_name' => 'iboot/users',
                'status' => Plugin::STATUS_INSTALLED,
                'is_default' => Plugin::IS_NOT_DEFAULT,
                'is_parent' => Plugin::IS_NOT_PARENT,
                'child_of' => 2,
                'scripts' => null,
                'icon' => null,
                'order' => 4,
                'route' => 'users.index',
                'image' => 'core/images/plugins/user.png',
                'description' => 'Manage users'
            ],
        ]);
    }
}
