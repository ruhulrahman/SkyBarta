<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privacies')->insert([
            [
            'id' => 1,
            'name' => 'Public',
            ],
            [
            'id' => 2,
            'name' => 'Private',
            ],
            [
            'id' => 3,
            'name' => 'Friends',
            ],
        ]);
    }
}
