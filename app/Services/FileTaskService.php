<?php

namespace App\Services;

use App\Http\Requests\AddFileTaskRequest;
use App\Http\Resources\FileTaskResource;
use App\Models\FileTask;
use App\Repositories\FileTaskRepository;

class FileTaskService {

    protected $fileTaskRepository;

    public function __construct(FileTaskRepository $fileTaskRepository)
    {
        $this->fileTaskRepository = $fileTaskRepository;
    }

    public function createFileTask(AddFileTaskRequest $request)
    {
        $this->fileTaskRepository->createFileTask($request);

        return ["message" => "Pytanie otwarte zostało poprawnie utworzone!"];
    }

    public function getAllFileTasks(string $userId)
    {
        return FileTaskResource::collection($this->fileTaskRepository->getAllUserfileTask($userId));
    }
}