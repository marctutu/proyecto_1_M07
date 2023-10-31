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
            'email' => 'admin@fp.insjoaquimmir.cat',
            'password' => Hash::make('123456789'),
            'role_id' => 3,  // Asigna el rol admin
        ]);
    }
}
/* Parte de abajo es la orginal del fichero */

/*namespace Database\Seeders;

/*use Illuminate\Database\Console\Seeds\WithoutModelEvents;
/*use Illuminate\Database\Seeder;

/*class UserSeeder extends Seeder
/*{
    /**
     * Run the database seeds.
     */
/*    public function run(): void */
   /* {*/
        //
/*    }*/
/*}*/
