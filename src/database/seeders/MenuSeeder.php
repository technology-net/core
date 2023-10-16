<?php

namespace IBoot\Core\Database\Seeders;

use Carbon\Carbon;
use IBoot\Core\app\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();

        Menu::query()->insert([
            [
                'menu_type' => 'sidebar',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
