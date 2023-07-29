<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProvinceSeeder::class,
            CompanySeeder::class,
            CategorySeeder::class,
            ContractSeeder::class,
            EarnTimeSeeder::class,
            WorkTimeSeeder::class,
            WorkTypeSeeder::class,
        ]);
    }
}
