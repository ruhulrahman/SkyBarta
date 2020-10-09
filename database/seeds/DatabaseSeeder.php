<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GenderSeeder::class,
            SiteInfoSeeder::class,
            ReligionSeeder::class,
            RelationSeeder::class,
            PrivacySeeder::class,
            RoleSeeder::class,
            SkillSeeder::class,
            BloodsTableSeeder::class,
            ProfessionsTableSeeder::class,
            PostsTableSeeder::class,
            DegreeSeeder::class,
            MajorTableSeeder::class,
            DivisionSeeder::class,
            DistrictSeeder::class,
            ThanaSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
