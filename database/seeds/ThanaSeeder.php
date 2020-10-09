<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThanaSeeder extends Seeder
{

    public function run()
    {
        DB::table('thanas')->insert([
            [
            'id' => 1,
            'name' => 'Tejgaon',
            'district_id' => 1,
            ],
            [
            'id' => 2,
            'name' => 'Ramna',
            'district_id' => 1,
            ],
            [
            'id' => 3,
            'name' => 'Dhanmondi',
            'district_id' => 1,
            ],
            [
            'id' => 4,
            'name' => 'Uttara',
            'district_id' => 1,
            ],
            [
            'id' => 5,
            'name' => 'Mohammadpur',
            'district_id' => 1,
            ],
            [
            'id' => 6,
            'name' => 'Mirpur',
            'district_id' => 1,
            ],
            [
            'id' => 7,
            'name' => 'Natore',
            'district_id' => 8,
            ],
            [
            'id' => 8,
            'name' => 'Singra',
            'district_id' => 8,
            ],
        ]);
    }
}
