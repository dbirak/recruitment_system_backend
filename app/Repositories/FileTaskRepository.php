<?php

namespace App\Repositories;

use App\Http\Requests\AddFileTaskRequest;
use App\Http\Requests\TaskUserAnswerRequest;
use App\Models\FileAnswer;
use App\Models\FileTask;

class FileTaskRepository {

    protected $fileTask;
    protected $fileAnswer;

    public function __construct(FileTask $fileTask, FileAnswer $fileAnswer)
    {
        $this->fileTask = $fileTask;
        $this->fileAnswer = $fileAnswer;
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

    public function getFileTaskById(string $fileTaskId)
    {
        return $this->fileTask::where('id', $fileTaskId)->get();
    }

    public function checkPermissionToFileTask(string $fileTaskId, string $userId)
    {
        $testTask = $this->fileTask::where('id', $fileTaskId)->first();
        
        return $testTask['user_id'] == $userId ? true : false ;
    }

    public function createFileAnswer(TaskUserAnswerRequest $request)
    {
        $file = $request->file('answer');
        $path = $file->store('public/fileAnswer');

        $newFileAnswer = new FileAnswer();
        $newFileAnswer->original_name = $file->getClientOriginalName();
        $newFileAnswer->storage_name = $file->hashName();
        $newFileAnswer->save();

        return $newFileAnswer;
    }
}