<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456789'),
            'role_id' => 3,  // Asigna el rol admin
        ]);

        User::create([
            'name' => 'editor',
            'email' => 'editor@editor.com',
            'password' => Hash::make('123456789'),
            'role_id' => 2,  // Asigna el rol admin
        ]);

        User::create([
            'name' => 'author',
            'email' => 'author@author.com',
            'password' => Hash::make('123456789'),
            'role_id' => 1,  // Asigna el rol admin
        ]);

        
    }
}
