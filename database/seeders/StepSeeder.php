<?php

namespace Database\Seeders;

use App\Models\Step;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Step::truncate();
        Schema::enableForeignKeyConstraints();
        Step::upsert(
            [
                [
                    'announcement_id' => 1,
                    'step_number' => 1,
                    'task_id' => 4,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => Carbon::now()->addDays(10)->toDateString(),
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => 1,
                ],
                [
                    'announcement_id' => 1,
                    'step_number' => 2,
                    'task_id' => 1,
                    'test_task_id' => 1,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => null,
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => null,
                ],
                [
                    'announcement_id' => 1,
                    'step_number' => 3,
                    'task_id' => 2,
                    'test_task_id' => null,
                    'open_task_id' => 1,
                    'expiry_date' => null,
                    'file_task_id' => null,
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => null,
                ],
                [
                    'announcement_id' => 1,
                    'step_number' => 4,
                    'task_id' => 3,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => 1,
                    'expiry_date' => null,
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => null,
                ],
                [
                    'announcement_id' => 2,
                    'step_number' => 1,
                    'task_id' => 4,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => Carbon::now()->addDays(8)->toDateString(),
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => 1,
                ],
                [
                    'announcement_id' => 3,
                    'step_number' => 1,
                    'task_id' => 4,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => Carbon::now()->addDays(12)->toDateString(),
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => 1,
                ],
                [
                    'announcement_id' => 4,
                    'step_number' => 1,
                    'task_id' => 4,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => Carbon::now()->addDays(17)->toDateString(),
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => 1,
                ],
                [
                    'announcement_id' => 5,
                    'step_number' => 1,
                    'task_id' => 4,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => Carbon::now()->addDays(6)->toDateString(),
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => 1,
                ],
                [
                    'announcement_id' => 6,
                    'step_number' => 1,
                    'task_id' => 4,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => Carbon::now()->addDays(8)->toDateString(),
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => 1,
                ],
                [
                    'announcement_id' => 7,
                    'step_number' => 1,
                    'task_id' => 4,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => Carbon::now()->addDays(16)->toDateString(),
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => 1,
                ],
                [
                    'announcement_id' => 8,
                    'step_number' => 1,
                    'task_id' => 4,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => Carbon::now()->addDays(11)->toDateString(),
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => 1,
                ],
                [
                    'announcement_id' => 9,
                    'step_number' => 1,
                    'task_id' => 4,
                    'test_task_id' => null,
                    'open_task_id' => null,
                    'file_task_id' => null,
                    'expiry_date' => Carbon::now()->addDays(18)->toDateString(),
                    'applied_users' => json_encode([]),
                    'rejected_users' => json_encode([]),
                    'accepted_users' => json_encode([]),
                    'is_active' => 1,
                ]
            ],
            'announcement_id'
        );
    }
}
