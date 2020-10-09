<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('religions')->insert([
            [
            'id' => 1,
            'name' => 'Islam',
            ],
            [
            'id' => 2,
            'name' => 'Hinduism',
            ],
            [
            'id' => 3,
            'name' => 'Christianity',
            ],
            [
            'id' => 4,
            'name' => 'Buddhism',
            ],
            [
            'id' => 5,
            'name' => 'Other',
            ],
        ]);
    }
}
