<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'level' => 'admin',
            'password' => bcrypt('123456'),
        ];

        User::create($user);
    }
}
