<?php

namespace IBoot\Core\Database\Seeders;

use Carbon\Carbon;
use IBoot\Core\App\Models\Plugin;
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

        Plugin::query()->truncate();
        Plugin::query()->insert([
            [
                'name_package' => 'CMS',
                'version' => null,
                'composer_name' => 'iboot/cms',
                'menu_items' => json_encode([
                    'name' => 'CMS',
                    'url' => null,
                    'icon' => '<i class="mdi mdi-content-save-all-outline"></i>',
                    'children' => [
                        [
                            'name' => 'Categories',
                            'url' => 'categories.index',
                            'icon' => null,
                            'children' => []
                        ],
                        [
                            'name' => 'Posts',
                            'url' => 'posts.index',
                            'icon' => null,
                            'children' => []
                        ],
                        [
                            'name' => 'Pages',
                            'url' => 'pages.index',
                            'icon' => null,
                            'children' => []
                        ]
                    ]
                ]),
                'status' => Plugin::STATUS_UNINSTALLED,
                'is_default' => Plugin::IS_NOT_DEFAULT,
                'scripts' => null,
                'image' => 'core/images/plugins/cms.png',
                'description' => 'Content Management System',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
