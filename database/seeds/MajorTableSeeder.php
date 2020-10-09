<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('majors')->insert([
            [
            'id' => 1,
            'name' => 'Science',
            ],
            [
            'id' => 2,
            'name' => 'Arts',
            ],
            [
            'id' => 3,
            'name' => 'Commerce',
            ],
            [
            'id' => 4,
            'name' => 'Engineering',
            ],
            [
            'id' => 5,
            'name' => 'Medical',
            ],
            [
            'id' => 6,
            'name' => 'Common',
            ]
        ]);
    }
}
