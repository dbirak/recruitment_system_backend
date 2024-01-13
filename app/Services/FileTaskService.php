<?php

namespace App\Services;

use App\Http\Requests\AddFileTaskRequest;
use App\Http\Resources\FileTaskResource;
use App\Models\FileTask;
use App\Repositories\FileTaskRepository;
use App\Repositories\StepRepository;
use Exception;
use Illuminate\Support\Facades\Storage;

class FileTaskService {

    protected $fileTaskRepository;
    protected $stepRepository;

    public function __construct(FileTaskRepository $fileTaskRepository, StepRepository $stepRepository)
    {
        $this->fileTaskRepository = $fileTaskRepository;
        $this->stepRepository = $stepRepository;
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

    public function showFileTask(string $fileTaskId, string $userId)
    {
        $fileTask = $this->fileTaskRepository->getFileTaskById($fileTaskId);

        if(!isset($fileTask[0])) throw new Exception("Nie znaleziono pytania!");

        if($this->fileTaskRepository->checkPermissionToFileTask($fileTask[0]['id'], $userId) == 0) throw new Exception("Brak dostępu do zasobu!");

        return $fileTask[0];
    }

    public function showFileAnswer(string $fileName)
    {
        if (Storage::exists('public/fileAnswer/'.$fileName)) {
            return Storage::response('public/fileAnswer/'.$fileName, $fileName, [
                'Content-Type' => 'octet-stream',
                'Content-Disposition' => 'inline; filename="' . $fileName . '"'
            ]);
        }
    }

    public function deleteFileTask(string $fileTaskid, string $userId)
    {
        $fileTask = $this->fileTaskRepository->getFileTaskById($fileTaskid);

        if(!isset($fileTask[0])) throw new Exception("Nie znaleziono pytania!");

        if($this->fileTaskRepository->checkPermissionToFileTask($fileTask[0]['id'], $userId) == 0) throw new Exception("Brak dostępu do zasobu!");

        $steps = $this->stepRepository->getStepsByFileTask($fileTaskid);

        if(isset($steps[0])) throw new Exception("Nie można usunąć pytania, ponieważ jest już użyte w etapie rekrutacji!");

        $this->fileTaskRepository->deleteFileTask($fileTaskid);

        return ["message" => "Moduł plikowy został poprawnie usunięty!"];
    }
}