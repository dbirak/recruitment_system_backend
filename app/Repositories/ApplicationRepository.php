<?php

namespace App\Repositories;

use App\Http\Requests\AddCvTaskAnswerRequest;
use App\Http\Requests\UserApplicationInfoRequest;
use App\Models\Application;
use App\Models\CvAnswer;
use App\Models\Step;

class ApplicationRepository {

    protected $application;
    protected $cvAnswer;
    protected $step;

    public function __construct(Application $application, CvAnswer $cvAnswer, Step $step)
    {
        $this->application = $application;
        $this->cvAnswer = $cvAnswer;
        $this->step = $step;
    }

    public function getAllUserApplication(string $userId, string $announcementId)
    {
        return $this->application::where("user_id", $userId)->where("announcement_id", $announcementId)->orderby("step_number", "asc")->get();
    }

    public function getApplicationById(string $userId, string $announcementId, string $stepId)
    {
        return $this->application::where("user_id", $userId)->where("announcement_id", $announcementId)->orderby("step_number", "asc")->where("step_id", $stepId)->first();
    }

    public function createCvTaskAnswer(AddCvTaskAnswerRequest $request, Step $firstCvStep)
    {
        $pdf = $request->file('cv');
        $path = $pdf->store('public/cv');

        $cvTaskAnswer = new CvAnswer();
        $cvTaskAnswer->original_name = $pdf->getClientOriginalName();
        $cvTaskAnswer->storage_name = $pdf->hashName();
        $cvTaskAnswer->save();

        $newApplication = new Application();
        $newApplication->announcement_id = $request['announcement_id'];
        $newApplication->user_id = $request->user()->id;
        $newApplication->step_id = $firstCvStep['id'];
        $newApplication->step_number = 1;
        $newApplication->task_id = 4;
        $newApplication->cv_answer_id = $cvTaskAnswer['id'];
        $newApplication->save();

        $actualStep = $this->step::where("announcement_id", $request['announcement_id'])->where("step_number", 1)->where("task_id", 4)->first();
        $appliedUsers = json_decode($actualStep['applied_users']);
        array_push($appliedUsers, $request->user()->id);
        $actualStep['applied_users'] = json_encode($appliedUsers);
        $actualStep->save();

        return $newApplication;
    }

    public function getUserApplication(UserApplicationInfoRequest $request)
    {
        return $this->application::where("announcement_id", $request['announcement_id'])->where("user_id", $request['user_id'])->where('step_id', $request['step_id'])->where('step_number', $request['step_number'])->first();
    }
}