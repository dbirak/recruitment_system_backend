<?php

namespace Database\Seeders;

use App\Models\WorkType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class WorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        WorkType::truncate();
        Schema::enableForeignKeyConstraints();
        WorkType::upsert(
            [
                [
                    'work_type_name' => 'Praca stacjonarna',
                ],
                [
                    'work_type_name' => 'Praca hybrydowa',
                ],
                [
                    'work_type_name' => 'Praca zdalna',
                ],
                [
                    'work_type_name' => 'Praca mobilna',
                ]
            ],
            'work_type_name'
        );
    }
}
