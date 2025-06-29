<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria um usuário admin específico
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@alfasoft.com',
            'password' => Hash::make('123456'), 
            'email_verified_at' => now(), 
        ]);

    }
}
