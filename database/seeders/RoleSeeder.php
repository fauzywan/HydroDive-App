<?php

namespace Database\Seeders;

use App\Models\Role;
use Database\Factories\RoleFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'admin', 'organization' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'parent', 'organization' => 0,'created_at' => now(), 'updated_at' => now()],
            ['name' => 'athlete', 'organization' => 0,'created_at' => now(), 'updated_at' => now()],
            ['name' => 'guardian', 'organization' => 1,'created_at' => now(), 'updated_at' => now()],
            ['name' => 'club', 'organization' => 1,'created_at' => now(), 'updated_at' => now()],
            ['name' => 'nation', 'organization' => 1,'created_at' => now(), 'updated_at' => now()],
            ['name' => 'city', 'organization' => 1,'created_at' => now(), 'updated_at' => now()],
            ['name' => 'province', 'organization' => 1,'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('roles')->insert($categories);

    }
}
