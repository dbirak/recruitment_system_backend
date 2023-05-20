<?php

namespace Database\Seeders;

use App\Models\WorkTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class WorkTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        WorkTime::truncate();
        Schema::enableForeignKeyConstraints();
        WorkTime::upsert(
            [
                [
                    'work_time_name' => 'Część etatu',
                ],
                [
                    'work_time_name' => 'Dodatkowa / tymczasowa',
                ],
                [
                    'work_time_name' => 'Pełny etat',
                ]
            ],
            'work_time_name'
        );
    }
}
