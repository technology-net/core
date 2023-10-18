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
                'name_package' => 'CMS',
                'version' => null,
                'composer_name' => 'iboot/cms',
                'menu_items' => json_encode([
                    'name' => 'CMS',
                    'slug' => null,
                    'icon' => '<i class="mdi mdi-content-save-all-outline"></i>',
                    'children' => [
                        [
                            'name' => 'Posts',
                            'slug' => null,
                            'icon' => null,
                            'children' => []
                        ],
                        [
                            "name" => "Categories",
                            "slug" => null,
                            "icon" => null,
                            "children" => []
                        ],
                        [
                            "name" => "Tags",
                            "slug" => null,
                            "icon" => null,
                            "children" => []
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
