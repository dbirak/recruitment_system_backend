<?php

namespace App\Repositories;

use App\Http\Requests\AddAnnouncementRequest;
use App\Http\Requests\BeginNewStepRequest;
use App\Http\Requests\ManagmentUsersRequest;
use App\Models\Announcement;
use App\Models\Step;
use Ramsey\Uuid\Type\Integer;

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

    public function managmentUsers(ManagmentUsersRequest $request)
    {
        $updatedStep = $this->step::where('id', $request['id'])->first();

        $updatedStep['applied_users'] = json_encode($request['applied_users']);
        $updatedStep['rejected_users'] = json_encode($request['rejected_users']);
        $updatedStep['accepted_users'] = json_encode($request['accepted_users']);
        $updatedStep->save();  

        return $updatedStep;
    }

    public function beginNewStepInAnnouncement(BeginNewStepRequest $request, Step $step, $allSteps)
    {
        $allSteps[$step['step_number'] - 2]['is_active'] = false;
        $allSteps[$step['step_number'] - 2]->save();

        $step['expiry_date'] = $request['data_zakonczenia'];
        $step['is_active'] = true;
        $step->save();

        return $step;
    }

    public function addNewAppliedToStep(int $stepId, string $userId)
    {
        $updatedStep = $this->step::where("id", $stepId)->first();
        $appliedUsers = json_decode($updatedStep['applied_users']);
        array_push($appliedUsers, intval($userId));
        $updatedStep['applied_users'] = json_encode($appliedUsers);
        $updatedStep->save();
    }

    public function getAppliedFirstSteps(string $userId)
    {
        return $this->step::where('step_number', 1)->where('applied_users', 'LIKE', "%".$userId."%")->orwhere('rejected_users', 'LIKE', "%".$userId."%")->orwhere('accepted_users', 'LIKE', "%".$userId."%")->get();
    }
}