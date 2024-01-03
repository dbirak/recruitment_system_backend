<?php

namespace Database\Seeders;

use App\Models\AnswerQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AnswerQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AnswerQuestion::truncate();
        Schema::enableForeignKeyConstraints();
        AnswerQuestion::upsert(
            [
                [
                    'question_id' => 1,
                    'answer_id' => 1,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 1,
                    'answer_id' => 2,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 1,
                    'answer_id' => 3,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 1,
                    'answer_id' => 4,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 1,
                    'answer_id' => 5,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 2,
                    'answer_id' => 6,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 2,
                    'answer_id' => 7,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 2,
                    'answer_id' => 8,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 2,
                    'answer_id' => 9,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 3,
                    'answer_id' => 10,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 3,
                    'answer_id' => 11,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 3,
                    'answer_id' => 12,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 3,
                    'answer_id' => 13,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 4,
                    'answer_id' => 14,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 4,
                    'answer_id' => 15,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 4,
                    'answer_id' => 16,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 4,
                    'answer_id' => 17,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 5,
                    'answer_id' => 18,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 5,
                    'answer_id' => 19,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 5,
                    'answer_id' => 20,
                    'test_task_id' => 1,
                ],
                [
                    'question_id' => 5,
                    'answer_id' => 21,
                    'test_task_id' => 1,
                ]
            ],
            'answer'
        );
    }
}
