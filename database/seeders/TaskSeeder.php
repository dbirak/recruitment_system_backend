<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Task::truncate();
        Schema::enableForeignKeyConstraints();
        Task::upsert(
            [
                [
                    'task_name' => 'testTask',
                ],
                [
                    'task_name' => 'openTask',
                ],
                [
                    'task_name' => 'fileTask',
                ],
                [
                    'task_name' => 'cvTask',
                ]
            ],
            'task_name'
        );
    }
}
