<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Owner Ganteng",
            'username' => "owner",
            'email' => "owner@gmail.com",
            'phone' => "08123456789",
            'nik' => "123456789",
            'password' => bcrypt('owner'),
            'role' => "owner",
        ]);

        User::create([
            'name' => "Admin Ganteng",
            'username' => "admin",
            'email' => "admin@gmail.com",
            'phone' => "08123456789",
            'nik' => "123456789",
            'password' => bcrypt('admin'),
            'role' => "admin",
        ]);

        User::create([
            'name' => "Kasir Ganteng",
            'username' => "KSR1",
            'email' => "ksr1@gmail.com",
            'phone' => "08123456789",
            'nik' => "123456789",
            'password' => bcrypt('KSR1'),
            'role' => "user",
        ]);
    }
}
