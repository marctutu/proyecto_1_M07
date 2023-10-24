<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'author'],
            ['id' => 2, 'name' => 'editor'],
            ['id' => 3, 'name' => 'admin'],
        ]);
    }
}
