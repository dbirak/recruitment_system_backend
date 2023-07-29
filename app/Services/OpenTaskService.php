<?php

namespace App\Services;

use App\Http\Requests\AddOpenTaskRequest;
use App\Http\Resources\OpenTaskResource;
use App\Models\OpenTask;
use App\Repositories\OpenTaskRepository;
use Exception;

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

    public function showOpenTask(string $openTaskid, string $userId)
    {
        $openTask = $this->openTaskRepository->getOpenTaskById($openTaskid);

        if(!isset($openTask[0])) throw new Exception("Nie znaleziono pytania!");

        if($this->openTaskRepository->checkPermissionToOpenTask($openTask[0]['id'], $userId) == 0) throw new Exception("Brak dostępu do zasobu!");

        return $openTask[0];
    }
}