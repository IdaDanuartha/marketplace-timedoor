<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating admin user...');

        $adminUser = User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'profile_image' => 'https://ui-avatars.com/api/?name=Admin&size=200',
        ]);

        Admin::create([
            'user_id' => $adminUser->id,
            'name' => 'System Administrator',
        ]);

        $this->command->info('✓ Admin created successfully');
    }
}