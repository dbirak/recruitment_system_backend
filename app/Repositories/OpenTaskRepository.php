<?php

namespace App\Repositories;

use App\Http\Requests\AddOpenTaskRequest;
use App\Models\OpenTask;

class OpenTaskRepository {

    protected $openTask;

    public function __construct(OpenTask $openTask)
    {
        $this->openTask = $openTask;
    }

    public function createOpenTask(AddOpenTaskRequest $request)
    {
        $newOpenTask = new OpenTask();
        $newOpenTask->name = $request['nazwa'];
        $newOpenTask->time = $request['czas'];
        $newOpenTask->descryption = $request['opis'];
        $newOpenTask->user_id = $request->user()->id;
        $newOpenTask->save();
    }

    public function getAllUserOpenTask(string $userId)
    {
        return $this->openTask::where("user_id", $userId)->get();
    }
}