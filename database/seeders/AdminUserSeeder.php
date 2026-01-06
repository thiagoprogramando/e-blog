<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder {
    
    public function run(): void {
        User::updateOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Administrador',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
