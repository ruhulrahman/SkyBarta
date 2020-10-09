<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert([
            [
            'id' => 1,
            'name' => 'Male',
            ],
            [
            'id' => 2,
            'name' => 'Female',
            ],
            [
            'id' => 3,
            'name' => 'Shemale',
            ],
        ]);
    }
}
