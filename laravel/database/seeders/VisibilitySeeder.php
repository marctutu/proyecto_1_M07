<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visibility;

class VisibilitySeeder extends Seeder
{
    public function run()
    {
        Visibility::create(['name' => 'public']);
        Visibility::create(['name' => 'contacts']);
        Visibility::create(['name' => 'private']);
    }
}