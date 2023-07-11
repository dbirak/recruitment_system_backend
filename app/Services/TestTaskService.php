<?php

namespace App\Services;

use App\Http\Requests\AddTestRequest;
use App\Repositories\TestRepository;
use App\Repositories\TestTaskRepository;

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
}