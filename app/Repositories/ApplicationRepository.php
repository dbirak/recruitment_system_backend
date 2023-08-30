<?php

namespace App\Repositories;

use App\Http\Requests\AddCvTaskAnswerRequest;
use App\Models\Application;
use App\Models\CvAnswer;
use App\Models\Step;

class ApplicationRepository {

    protected $application;
    protected $cvAnswer;

    public function __construct(Application $application, CvAnswer $cvAnswer)
    {
        $this->application = $application;
        $this->cvAnswer = $cvAnswer;
    }

    public function getAllUserApplication(string $userId, string $announcementId)
    {
        return $this->application::where("user_id", $userId)->where("announcement_id", $announcementId)->orderby("step_number", "asc")->get();
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

        return $newApplication;
    }
}