<?php

namespace App\Services;

use App\Http\Requests\AddTestRequest;
use App\Http\Resources\AnswerQuestionResource;
use App\Http\Resources\TestTaskCollection;
use App\Http\Resources\TestTaskResource;
use App\Models\TestTask;
use App\Repositories\TestRepository;
use App\Repositories\TestTaskRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;

class TestTaskService {

    protected $testTaskRepository;

    public function __construct(TestTaskRepository $testTaskRepository)
    {
        $this->testTaskRepository = $testTaskRepository;
    }

    public function createTest(AddTestRequest $request)
    {
        $this->testTaskRepository->createTest($request);

        return ["message" => "Test został poprawnie utworzony!"];
    }

    public function getAllTests(string $userId)
    {
        //return TestTaskResource::collection($this->testTaskRepository->getAllUserTestTask($userId));

        $testTasks = $this->testTaskRepository->getAllUserTestTask($userId);

        // $answerQuestions = $this->testTaskRepository->getAllUserAnswerQuestions($testTask['id']);

        $res = [];

        foreach($testTasks as $testTask)
        {
            $countQuestionsFromTests = $this->testTaskRepository->getCountQuesitionFromTest($testTask['id']);
            $testTask['questions_count'] = $countQuestionsFromTests;

            array_push($res, $testTask);
        }

        return TestTaskResource::collection($res);
    }

    public function showTest(string $testId, string $userId)
    {
        $questions = $this->testTaskRepository->getTestById($testId);

        if(!isset($questions[0])) throw new Exception("Nie znaleziono pytań do testu!");
        if($this->testTaskRepository->checkPermissionToTest($questions[0]['test_task_id'], $userId) == 0) throw new Exception("Brak dostępu do zasobu!");

        return AnswerQuestionResource::collection($questions);
    }
}