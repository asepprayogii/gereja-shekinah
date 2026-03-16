<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun Admin
        User::create([
            'name'     => 'Admin GPdI Shekinah',
            'email'    => 'admin@shekinah.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Buat akun Gembala
        User::create([
            'name'     => 'Gembala Shekinah',
            'email'    => 'gembala@shekinah.com',
            'password' => Hash::make('gembala123'),
            'role'     => 'gembala',
        ]);
    }
}