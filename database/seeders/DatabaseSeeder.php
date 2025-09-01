<?php

namespace Database\Seeders;


use App\Models\settings;
use Database\Seeders\RoleSeeder;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        settings::create(['password_default'=>123,'registration_fee'=>1000000,'data_per_page'=>5]);
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            clubSeeder::class,
            AthleteSeeder::class,
            CoachCategorySeeder::class,
            branchSeeder::class,

        ]);

    }
}
