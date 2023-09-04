<?php

namespace App\Repositories;

use App\Http\Requests\AddAnnouncementRequest;
use App\Models\Announcement;
use App\Models\Step;

class StepRepository {

    protected $step;

    public function __construct(Step $step)
    {
        $this->step = $step;
    }

    public function createStep(AddAnnouncementRequest $request, string $announcementId)
    {
        $newStep = new Step();
        $newStep->announcement_id = $announcementId;
        $newStep->step_number = 1;
        $newStep->task_id = 4;  // cvTask
        $newStep->expiry_date = $request['data_zakonczenia'];
        $newStep->applied_users = json_encode([]);
        $newStep->rejected_users = json_encode([]);
        $newStep->accepted_users = json_encode([]);
        $newStep->is_active = true;
        $newStep->save();

        $stepNumber = 2;

        foreach ($request['etapy'] as $step) 
        {
            $newStep = new Step();
            $newStep->announcement_id = $announcementId;
            $newStep->step_number = $stepNumber;
            $newStep->applied_users = json_encode([]);
            $newStep->rejected_users = json_encode([]);
            $newStep->accepted_users = json_encode([]);
            
            if($step['module'] == "test") 
            {
                $newStep->task_id = 1;
                $newStep->test_task_id = $step['task']['id'];
            }
            else if($step['module'] == "openTask") 
            {
                $newStep->task_id = 2;
                $newStep->open_task_id = $step['task']['id'];

            }
            else if($step['module'] == "fileTask") 
            {
                $newStep->task_id = 3;
                $newStep->file_task_id = $step['task']['id'];

            }

            $newStep->save();

            $stepNumber++;
        }
    }

    public function getStepsFromAnnouncement(string $announcementId)
    {
        return $this->step::where('announcement_id', $announcementId)->orderby("step_number", "asc")->get();
    }

    public function getStepById(string $stepId)
    {
        return $this->step::where('id', $stepId)->first();
    }
}