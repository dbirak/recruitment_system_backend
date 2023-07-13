<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\AnswerQuestion;
use App\Models\Question;
use App\Models\TestTask;
use Illuminate\Support\Facades\DB;

class TestTaskRepository {

    protected $testTask;
    protected $answerQuestion;

    public function __construct(TestTask $testTask, AnswerQuestion $answerQuestion)
    {
        $this->testTask = $testTask;
        $this->answerQuestion = $answerQuestion;
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

    public function getAllUserTestTask(string $userId)
    {
        return $this->testTask::where('user_id', $userId)->get();
    }

    public function getAllUserAnswerQuestions(int $id)
    {
        return $this->answerQuestion::where('test_task_id', $id)->get();
    }

    public function getCountQuesitionFromTest(int $testId)
    {
        return $questions = DB::table('answer_questions')->where('test_task_id', $testId)->select('question_id')->distinct()->get()->count();
    }

    public function getTestById(string $testId)
    {
        return $this->answerQuestion::where('test_task_id', $testId)->get();
    }

    public function checkPermissionToTest(int $testId, string $userId)
    {
        $test = $this->testTask::where('id', $testId)->first();
        
        return $test['user_id'] == $userId ? true : false ; 
    }
}