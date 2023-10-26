<?php

namespace IBoot\Core\Database\Seeders;

use IBoot\Core\App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@icitech.net',
            'name' => 'Admin',
            'status' => User::STATUS_ACTIVATED,
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);
    }
}
