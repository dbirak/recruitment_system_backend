<?php

namespace App\Services;

use App\Http\Requests\AddOpenTaskRequest;
use App\Http\Resources\OpenTaskResource;
use App\Models\OpenTask;
use App\Repositories\OpenTaskRepository;

class OpenTaskService {

    protected $openTaskRepository;

    public function __construct(OpenTaskRepository $openTaskRepository)
    {
        $this->openTaskRepository = $openTaskRepository;
    }

    public function createOpenTask(AddOpenTaskRequest $request)
    {
        $this->openTaskRepository->createOpenTask($request);

        return ["message" => "Pytanie otwarte zostało poprawnie utworzone!"];
    }

    public function getAllOpenTasks(string $userId)
    {
        return OpenTaskResource::collection($this->openTaskRepository->getAllUserOpenTask($userId));
    }
}