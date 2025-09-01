<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class branchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch=[
            "Renang",
            "Loncat Indah",
            "Renang Indah",
            "Polo Air",
            "Renang Perairan Terbuka",
            "Master"];
            foreach ($branch as $b) {
                \App\Models\Branch::create([
                    "name"=>$b
                ]);
            }
    }
}
