<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([
            [
            'id' => 1,
            'name' => 'Dhaka',
            'division_id' => 1,
            ],
            [
            'id' => 2,
            'name' => 'Gazipur',
            'division_id' => 1,
            ],
            [
            'id' => 3,
            'name' => 'Narayanganj',
            'division_id' => 1,
            ],
            [
            'id' => 4,
            'name' => 'Gopalganj',
            'division_id' => 1,
            ],
            [
            'id' => 5,
            'name' => 'Narsingdi',
            'division_id' => 1,
            ],
            [
            'id' => 6,
            'name' => 'Chattogram',
            'division_id' => 2,
            ],
            [
            'id' => 7,
            'name' => 'Rajshahi',
            'division_id' => 3,
            ],
            [
            'id' => 8,
            'name' => 'Natore',
            'division_id' => 3,
            ],
            [
            'id' => 9,
            'name' => 'Pabna',
            'division_id' => 3,
            ],
            [
            'id' => 10,
            'name' => 'Sirajganj',
            'division_id' => 3,
            ],
            [
            'id' => 11,
            'name' => 'Bogura',
            'division_id' => 3,
            ],
            [
            'id' => 12,
            'name' => 'Khulna',
            'division_id' => 4,
            ],
            [
            'id' => 13,
            'name' => 'Bagerhat',
            'division_id' => 4,
            ],
            [
            'id' => 14,
            'name' => 'Sylhet',
            'division_id' => 5,
            ],
            [
            'id' => 15,
            'name' => 'Rangpur',
            'division_id' => 6,
            ],
            [
            'id' => 16,
            'name' => 'Dinajpur',
            'division_id' => 6,
            ],
            [
            'id' => 17,
            'name' => 'Barishal',
            'division_id' => 7,
            ],
            [
            'id' => 18,
            'name' => 'Bhola',
            'division_id' => 7,
            ],
            [
            'id' => 19,
            'name' => 'Mymensingh',
            'division_id' => 8,
            ],
        ]);

    }
}
