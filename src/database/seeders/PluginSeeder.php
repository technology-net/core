<?php

namespace IBoot\Core\Database\Seeders;

use Carbon\Carbon;
use IBoot\Core\app\Models\Plugin;
use Illuminate\Database\Seeder;

class PluginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();

        Plugin::query()->insert([
            [
                'name_package' => 'Dashboard',
                'version' => null,
                'composer_name' => null,
                'status' => Plugin::STATUS_INSTALLED,
                'is_default' => Plugin::IS_DEFAULT,
                'scripts' => null,
                'image' => 'core/images/plugins/dashboard.png',
                'description' => 'Manage dashboard',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name_package' => 'Platform',
                'version' => null,
                'composer_name' => 'iboot/platform',
                'status' => Plugin::STATUS_INSTALLED,
                'is_default' => Plugin::IS_NOT_DEFAULT,
                'scripts' => null,
                'image' => 'core/images/plugins/platform.png',
                'description' => 'Manage platform administration',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name_package' => 'Plugins',
                'version' => null,
                'composer_name' => null,
                'status' => Plugin::STATUS_INSTALLED,
                'is_default' => Plugin::IS_DEFAULT,
                'scripts' => null,
                'image' => 'core/images/plugins/plugin.png',
                'description' => 'Manage plugins (Active, deactivate, install or uninstall a package)',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name_package' => 'Users',
                'version' => null,
                'composer_name' => 'iboot/users',
                'status' => Plugin::STATUS_INSTALLED,
                'is_default' => Plugin::IS_NOT_DEFAULT,
                'scripts' => null,
                'image' => 'core/images/plugins/user.png',
                'description' => 'Manage users',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
