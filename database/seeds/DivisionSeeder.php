<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('divisions')->insert([
            [
            'id' => 1,
            'name' => 'Dhaka',
            ],
            [
            'id' => 2,
            'name' => 'Chattogram',
            ],
            [
            'id' => 3,
            'name' => 'Rajshahi',
            ],
            [
            'id' => 4,
            'name' => 'Khulna',
            ],
            [
            'id' => 5,
            'name' => 'Sylhet',
            ],
            [
            'id' => 6,
            'name' => 'Rangpur',
            ],
            [
            'id' => 7,
            'name' => 'Barishal',
            ],
            [
            'id' => 8,
            'name' => 'Mymensingh',
            ],
        ]);
    }
}
