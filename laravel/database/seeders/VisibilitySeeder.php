<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visibility;

class VisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $visibilities = [[
                'id'    => Visibility::PUBLIC,
                'name'  => 'public',
            ],[
                'id'    => Visibility::CONTACTS,
                'name'      => 'contacts',
            ],[
                'id'    => Visibility::PRIVATE,
                'name'      => 'private',
        ]];

        foreach ($visibilities as $visibility) {
            $v = new Visibility($visibility);
            $v->save();
        }
    }
}
