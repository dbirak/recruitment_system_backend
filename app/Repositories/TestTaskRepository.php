<?php

namespace App\Repositories;

use App\Http\Requests\TaskUserAnswerRequest;
use App\Models\Answer;
use App\Models\AnswerQuestion;
use App\Models\Question;
use App\Models\TestAnswer;
use App\Models\TestAnswerAnswer;
use App\Models\TestTask;
use Illuminate\Support\Facades\DB;

class TestTaskRepository {

    protected $testTask;
    protected $answerQuestion;

    protected $testAnswer;
    protected $testAnswerAnswer;

    public function __construct(TestTask $testTask, AnswerQuestion $answerQuestion, TestAnswer $testAnswer, TestAnswerAnswer $testAnswerAnswer)
    {
        $this->testTask = $testTask;
        $this->answerQuestion = $answerQuestion;
        $this->testAnswer = $testAnswer;
        $this->testAnswerAnswer = $testAnswerAnswer;
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

    public function getUserTestTaskById(string $id)
    {
        return $this->testTask::where('id', $id)->get();
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

    public function createTestAnswer(TaskUserAnswerRequest $request)
    {
        $newTestAnswer = new TestAnswer();
        $newTestAnswer->save();

        foreach ($request['answer'] as $question)
        {
            foreach ($question['odpowiedzi'] as $answer)
            {
                $newAnswerAnswer = new TestAnswerAnswer();
                $newAnswerAnswer->test_answer_id = $newTestAnswer['id'];
                $newAnswerAnswer->question_id = $question['id'];
                $newAnswerAnswer->answer_id = $answer['id'];
                $newAnswerAnswer->is_checked = $answer['is_markered'];
                $newAnswerAnswer->save();
            }
        }

        return $newTestAnswer;
    }
}