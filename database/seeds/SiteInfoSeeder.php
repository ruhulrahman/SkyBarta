<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_infos')->insert([
            [
            'id' => 1,
            'user_id' => 1,
            'title' => 'Social Site BD',
            'short_name' => 'SSB',
            'description' => 'Social Networking Site. Community choose this site',
            ]
        ]);
    }
}
