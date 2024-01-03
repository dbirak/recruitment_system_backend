<?php

namespace Database\Seeders;

use App\Models\TestTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TestTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        TestTask::truncate();
        Schema::enableForeignKeyConstraints();
        TestTask::upsert(
            [
                [
                    'name' => 'Test wiedzy z języka JAVA',
                    'time' => 20,
                    'user_id' => 12,
                ]
            ],
            'time'
        );
    }
}
