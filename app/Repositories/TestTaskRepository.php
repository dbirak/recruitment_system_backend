<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\AnswerQuestion;
use App\Models\Question;
use App\Models\TestTask;

class TestTaskRepository {

    protected $testTask;

    public function __construct(TestTask $testTask)
    {
        $this->testTask = $testTask;
    }

    public function createTest($request)
    {
        $newTask = new TestTask();
        $newTask->name = $request['nazwa'];
        $newTask->time = $request['czas'];
        $newTask->user_id = $request->user()->id;
        $newTask->save();

        foreach ($request['pytania'] as $question) 
        {
            $newQuestion = new Question();
            $newQuestion->question = $question['pytanie'];
            $newQuestion->save();

            foreach ($question['odpowiedzi'] as $answer) 
            {
                $newAnswer = new Answer();
                $newAnswer->answer = $answer['odpowiedz'];
                $newAnswer->is_correct = $answer['poprawna'];
                $newAnswer->save();

                $newAnswerQuestion = new AnswerQuestion();
                $newAnswerQuestion->question_id = $newQuestion->id;
                $newAnswerQuestion->answer_id = $newAnswer->id;
                $newAnswerQuestion->test_task_id = $newTask->id;
                $newAnswerQuestion->save();
            }
        }
    }
}