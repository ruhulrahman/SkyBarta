<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('posts')->insert([
            [
            'id' => 1,
            'user_id' => 1,
            'privacy_id' => 1,
            'desc' => 'Hello, This is dumy text',
            ],
        ]);
    }
}
