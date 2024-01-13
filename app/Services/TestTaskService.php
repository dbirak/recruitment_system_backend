<?php

namespace App\Services;

use App\Http\Requests\AddTestRequest;
use App\Http\Resources\AnswerQuestionResource;
use App\Http\Resources\TestTaskCollection;
use App\Http\Resources\TestTaskResource;
use App\Models\TestTask;
use App\Repositories\StepRepository;
use App\Repositories\TestRepository;
use App\Repositories\TestTaskRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;

class TestTaskService {

    protected $testTaskRepository;
    protected $stepRepository;

    public function __construct(TestTaskRepository $testTaskRepository, StepRepository $stepRepository)
    {
        $this->testTaskRepository = $testTaskRepository;
        $this->stepRepository = $stepRepository;
    }

    public function createTest(AddTestRequest $request)
    {
        $this->testTaskRepository->createTest($request);

        return ["message" => "Test został poprawnie utworzony!"];
    }

    public function getAllTests(string $userId)
    {

        $testTasks = $this->testTaskRepository->getAllUserTestTask($userId);

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

    public function deleteTestTask(string $testId, string $userId)
    {
        $questions = $this->testTaskRepository->getTestById($testId);

        if(!isset($questions[0])) throw new Exception("Nie znaleziono pytań do testu!");
        if($this->testTaskRepository->checkPermissionToTest($questions[0]['test_task_id'], $userId) == 0) throw new Exception("Brak dostępu do zasobu!");

        $steps = $this->stepRepository->getStepsByTestTask($testId);

        if(isset($steps[0])) throw new Exception("Nie można usunąć testu, ponieważ jest już użyty w etapie rekrutacji!");

        $this->testTaskRepository->deleteTest($testId);

        return ["message" => "Test został poprawnie usunięty!"];
    }
}