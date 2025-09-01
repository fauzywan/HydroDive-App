<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoachCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Belum Memiliki Jabatan'],
            ['name' => 'Head of Coach'],
            ['name' => 'Physical Coach'],
            ['name' => 'Swimming Tech'],
        ];

        DB::table('coach_categories')->insert($categories);
    }
}
