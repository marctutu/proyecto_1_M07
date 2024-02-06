<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['id' => Role::AUTHOR, 'name' => 'author']);
        Role::create(['id' => Role::EDITOR, 'name' => 'editor']);
        Role::create(['id' => Role::ADMIN,  'name' => 'admin']);
    }
}
