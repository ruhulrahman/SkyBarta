<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('degrees')->insert([
            [
            'id' => 1,
            'name' => 'PSC',
            ],
            [
            'id' => 2,
            'name' => 'JSC',
            ],
            [
            'id' => 3,
            'name' => 'SSC',
            ],
            [
            'id' => 4,
            'name' => 'HSC/Dakhil',
            ],
            [
            'id' => 5,
            'name' => 'Diploma',
            ],
            [
            'id' => 6,
            'name' => 'BSC/BA/B.Com/BBA/LLB',
            ],
            [
            'id' => 7,
            'name' => 'MSC/MA/M.Com/MBA/MLM',
            ],
            [
            'id' => 8,
            'name' => 'PHD',
            ],
        ]);
    }
}
