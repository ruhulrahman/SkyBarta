<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('unions')->insert([]);
    }
}
