<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        // $roles = DB::table('roles')->get();
        // $super_id ="";

        // foreach(reles as role){
        //     if($role->name == 'Super'){
        //         $super_id = $role->id;
        //     }
        // }

        DB::table('users')->insert([
            [
            'id' => 1,
            'name' => 'Ruhul',
            'email' => 'ruhulcsesu@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => 1,
            'aboutme' => 'I am a Software Engineer',
            'gender_id' => 1,
            'dob' => '14-02-1994',
            'religion_id' => 1,
            ],
        ]);

        // DB::table('user_locations')->insert([
        //     [
        //     'id' => 1,
        //     'user_id' => 1,
        //     ],
        // ]);

        // DB::table('user_education')->insert([
        //     [
        //     'id' => 1,
        //     'user_id' => 1,
        //     ],
        // ]);
    }
}
