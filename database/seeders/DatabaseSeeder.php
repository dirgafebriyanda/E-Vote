<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
         User::create([
            'username' => 'super_admin',
            'name' => 'Super admin',
            'email' => 'superadmin@gmail.com',
            'role' => 'Super admin',
            'password' => Hash::make('password'),
        ]);
    }
}
