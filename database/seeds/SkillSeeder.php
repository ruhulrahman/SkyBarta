<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            [
            'id' => 1,
            'name' => 'Python',
            ],
            [
            'id' => 2,
            'name' => 'Java',
            ],
            [
            'id' => 3,
            'name' => 'Ruby/Ruby on Rails',
            ],
            [
            'id' => 4,
            'name' => 'HTML',
            ],
            [
            'id' => 5,
            'name' => 'JavaScript',
            ],
            [
            'id' => 6,
            'name' => 'C Language',
            ],
            [
            'id' => 7,
            'name' => 'C++',
            ],
            [
            'id' => 8,
            'name' => 'C#',
            ],
            [
            'id' => 9,
            'name' => 'PHP',
            ],
            [
            'id' => 10,
            'name' => 'Laravel',
            ],
            [
            'id' => 11,
            'name' => 'Vuejs',
            ],
            [
            'id' => 12,
            'name' => 'Git',
            ],
            [
            'id' => 14,
            'name' => 'Firebase',
            ],
            [
            'id' => 15,
            'name' => 'Android',
            ],
            [
            'id' => 16,
            'name' => 'XML',
            ],
            [
            'id' => 17,
            'name' => 'CSS',
            ],
            [
            'id' => 18,
            'name' => 'Bootsrap',
            ],
            [
            'id' => 19,
            'name' => 'jQuery',
            ],
            [
            'id' => 20,
            'name' => 'Ajax',
            ],
            [
            'id' => 21,
            'name' => 'Reactjs',
            ],
            [
            'id' => 22,
            'name' => 'Wordpress',
            ],
        ]);
    }
}
