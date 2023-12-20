<?php

namespace IBoot\Core\Database\Seeders;

use IBoot\Core\App\Models\User;
use Spatie\Permission\Models\Role;
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
        User::query()->truncate();
        $user = User::create([
            'email' => 'admin@icitech.net',
            'name' => 'Admin',
            'status' => User::STATUS_ACTIVATED,
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        Role::query()->delete();
        $role = Role::create([
            'name' => 'Supper Admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user->assignRole($role);
    }
}
