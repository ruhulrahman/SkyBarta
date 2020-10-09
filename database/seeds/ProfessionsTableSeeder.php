<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('professions')->insert([
            [
            'id' => 1,
            'name' => 'Doctor',
            ],
            [
            'id' => 2,
            'name' => 'Engineer',
            ],
            [
            'id' => 3,
            'name' => 'Lawer',
            ],
            [
            'id' => 4,
            'name' => 'Banker',
            ],
            [
            'id' => 5,
            'name' => 'Teacher',
            ],
            [
            'id' => 6,
            'name' => 'Technician',
            ],
            [
            'id' => 7,
            'name' => 'Govt. Service',
            ],
            [
            'id' => 8,
            'name' => 'Student',
            ],
        ]);
    }
}
