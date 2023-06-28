<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Eko Prasetio',
                'username' => 'ekopras',
                'email' => 'ekopras@ekopras.com',
                'password' => '$2y$10$uBatLnuZ37l7Vbu3DOH4Ku8i1kqwvcr0VfkUV96bFJpgpvbX80hp6',
            ]
        ];

        User::insert($user);
    }
}
