<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@automarket.it'],
            [
                'name' => 'Admin Automarket',
                'password' => Hash::make('password123'), // cambialo
                'role' => 'admin',
            ]
        );
    }
}
