<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create a user
        $user = \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'bimasha@gmail.com',
            'username' => 'bimasha',
            'password' => '12345678',
            'phone' => '0712345678',
            'address' => 'Colombo',
            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod'
        ]);

        $user = \App\Models\User::create([
            'name' => 'Bimasha Doe',
            'email' => 'bimashaa@gmail.com',
            'username' => 'bimashaa',
            'password' => '12345678',
            'phone' => '0712345678',
            'address' => 'Colombo',
            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod'
        ]);
    }
}
