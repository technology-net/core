<?php

namespace IBoot\Core\Database\Seeders;

use IBoot\Core\app\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        SystemSetting::query()->truncate();
        SystemSetting::query()->insert([
            [
                'key' => 'filesystem_disk',
                'value' => 'disk_local',
                'deletable' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'disk_local',
                'value' => json_encode([
                    'driver' => 'local',
                    'root' => storage_path('app'),
                    'throw' => false,
                ]),
                'deletable' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'disk_s3',
                'value' => json_encode([
                    'driver' => 's3',
                    'key' => '',
                    'secret' => '',
                    'region' => '',
                    'bucket' => '',
                    'url' => '',
                    'endpoint' => '',
                    'use_path_style_endpoint' => '',
                    'throw' => false,
                ]),
                'deletable' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'disk_bunnycdn',
                'value' => json_encode([
                    'driver' => 'bunnycdn',
                    'storage_zone' => '',
                    'api_key' => '',
                    'region' => '',
                ]),
                'deletable' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
