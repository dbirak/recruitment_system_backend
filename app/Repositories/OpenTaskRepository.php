<?php

namespace App\Repositories;

use App\Http\Requests\AddOpenTaskRequest;
use App\Http\Requests\TaskUserAnswerRequest;
use App\Models\OpenAnswer;
use App\Models\OpenTask;

class OpenTaskRepository {

    protected $openTask;
    protected $openAnswer;

    public function __construct(OpenTask $openTask, OpenAnswer $openAnswer)
    {
        $this->openTask = $openTask;
        $this->openAnswer = $openAnswer;
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

    public function getOpenTaskById(string $openTaskId)
    {
        return $this->openTask::where('id', $openTaskId)->get();
    }

    public function checkPermissionToOpenTask(string $openTaskId, string $userId)
    {
        $openTask = $this->openTask::where('id', $openTaskId)->first();
        
        return $openTask['user_id'] == $userId ? true : false ;
    }

    public function createOpenAnswer(TaskUserAnswerRequest $request)
    {
        $newOpenAnswer = new OpenAnswer();
        $newOpenAnswer->answer = $request['answer'];
        $newOpenAnswer->save();

        return $newOpenAnswer;
    }

    public function getOpenAnswerById(string $id)
    {
        return $this->openAnswer::where('id', $id)->first();
    }

    public function getOpenTasksCountById(string $userId)
    {
        return $this->openTask::where('user_id', $userId)->count();
    }

    public function deleteOpenTask(string $id)
    {
        $this->openTask::where('id', $id)->delete();
    }
}