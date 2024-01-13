<?php

namespace App\Services;

use App\Http\Requests\AddOpenTaskRequest;
use App\Http\Resources\OpenTaskResource;
use App\Models\OpenTask;
use App\Repositories\OpenTaskRepository;
use App\Repositories\StepRepository;
use Exception;

class OpenTaskService {

    protected $openTaskRepository;
    protected $stepRepository;

    public function __construct(OpenTaskRepository $openTaskRepository, StepRepository $stepRepository)
    {
        $this->openTaskRepository = $openTaskRepository;
        $this->stepRepository = $stepRepository;
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

    public function deleteOpenTask(string $openTaskid, string $userId)
    {
        $openTask = $this->openTaskRepository->getOpenTaskById($openTaskid);

        if(!isset($openTask[0])) throw new Exception("Nie znaleziono pytania!");

        if($this->openTaskRepository->checkPermissionToOpenTask($openTask[0]['id'], $userId) == 0) throw new Exception("Brak dostępu do zasobu!");

        $steps = $this->stepRepository->getStepsByOpenTask($openTaskid);

        if(isset($steps[0])) throw new Exception("Nie można usunąć pytania, ponieważ jest już użyte w etapie rekrutacji!");

        $this->openTaskRepository->deleteOpenTask($openTaskid);

        return ["message" => "Pytanie otwarte zostało poprawnie usunięte!"];
    }
}