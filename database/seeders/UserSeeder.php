<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat user admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'), 
            'instansi' => 'Admin Instansi',
            'role' => 'admin', 
        ]);

        // Buat user biasa
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'), 
            'instansi' => 'User Instansi',
            'role' => 'user', 
        ]);
    }
}
