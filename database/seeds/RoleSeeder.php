<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
            'id' => 1,
            'name' => 'Super',
            ],
            [
            'id' => 2,
            'name' => 'Admin',
            ],
            [
            'id' => 3,
            'name' => 'User',
            ],
            [
            'id' => 4,
            'name' => 'Author',
            ],
        ]);
    }
}
