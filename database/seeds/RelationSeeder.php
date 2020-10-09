<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relations')->insert([
            [
            'id' => 1,
            'name' => 'Single',
            ],
            [
            'id' => 2,
            'name' => 'Married',
            ],
            [
            'id' => 3,
            'name' => 'In a Relationship',
            ],
            [
            'id' => 4,
            'name' => 'Divorced',
            ],
            [
            'id' => 5,
            'name' => 'Engaged',
            ],
            [
            'id' => 6,
            'name' => 'Widowed',
            ],
            [
            'id' => 7,
            'name' => 'Separated',
            ],
            [
            'id' => 8,
            'name' => 'Separated',
            ],
            [
            'id' => 9,
            'name' => 'Complicated',
            ],
        ]);
    }
}
