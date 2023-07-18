<?php

namespace App\Repositories;

use App\Http\Requests\AddFileTaskRequest;
use App\Models\FileTask;

class FileTaskRepository {

    protected $fileTask;

    public function __construct(FileTask $fileTask)
    {
        $this->fileTask = $fileTask;
    }

    public function createFileTask(AddFileTaskRequest $request)
    {
        $newFileTask = new FileTask();
        $newFileTask->name = $request['nazwa'];
        $newFileTask->time = $request['czas'];
        $newFileTask->descryption = $request['opis'];
        $newFileTask->user_id = $request->user()->id;
        $newFileTask->save();
    }

    public function getAllUserfileTask(string $userId)
    {
        return $this->fileTask::where("user_id", $userId)->get();
    }
}