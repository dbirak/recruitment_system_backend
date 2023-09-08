<?php

namespace App\Services;

use App\Http\Requests\AddCvTaskAnswerRequest;
use App\Http\Requests\AddFileTaskRequest;
use App\Http\Requests\ManagmentUsersRequest;
use App\Http\Resources\FileTaskResource;
use App\Http\Resources\StepResource;
use App\Http\Resources\StepResourceForUser;
use App\Http\Resources\UserApplicationResource;
use App\Models\FileTask;
use App\Repositories\AnnouncementRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\FileTaskRepository;
use App\Repositories\StepRepository;
use App\Repositories\UserRepository;
use Exception;

class ApplicationService {

    protected $applicationRepository;
    protected $stepRepository;
    protected $companyRepository;
    protected $announcementRepository;
    protected $userRepository;

    public function __construct(ApplicationRepository $applicationRepository, StepRepository $stepRepository, CompanyRepository $companyRepository, AnnouncementRepository $announcementRepository, UserRepository $userRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->stepRepository = $stepRepository;
        $this->companyRepository = $companyRepository;
        $this->announcementRepository = $announcementRepository;
        $this->userRepository = $userRepository;
    }

    public function storeCvTaskAnswer(AddCvTaskAnswerRequest $request)
    {
        $steps = $this->stepRepository->getStepsFromAnnouncement($request['announcement_id']);

        return $this->applicationRepository->createCvTaskAnswer($request, $steps[0]);
    }

    public function getUsersByStep(string $stepId, string $userId)
    {
        $step = $this->stepRepository->getStepById($stepId);
        
        if(!isset($step)) throw new Exception("Etap nie isnieje!");
        
        $announcement = $this->announcementRepository->getAnnouncementByIdWhitoutExpiryDate($step['announcement_id']);
        $company = $this->companyRepository->getCompanyByUserId($userId);
        
        if($announcement['company_id'] !== $company['id']) throw new Exception("Brak uprawnień do zasobu!");
        if($step['is_active'] === null) throw new Exception("Etap nie został rozpoczęty!");

        $notAppliedUsers = $step['step_number'] > 1 ? [] : null;
        $appliedUsers = [];
        $rejectedUsers = [];
        $acceptedUsers = [];

        $columnsName = ['applied_users', 'accepted_users', 'rejected_users'];

        if ($step['step_number'] > 1)
        {
            $steps = $this->stepRepository->getStepsFromAnnouncement($step['announcement_id']);
            $previewStep = $steps[$step['step_number'] - 2];

            $diff1 = array_diff(json_decode($step["applied_users"]), json_decode($previewStep['accepted_users']));
            $diff2 = array_diff(json_decode($previewStep['accepted_users']), json_decode($step["applied_users"]));

            foreach (array_merge($diff1, $diff2) as $userId)
            {
                array_push($notAppliedUsers, new UserApplicationResource($this->userRepository->getUserById($userId)));
            }
        }

        foreach ($columnsName as $column)
        {
            foreach (json_decode($step[$column]) as $userId)
            {
                $user = $this->userRepository->getUserById($userId);

                if($column === "applied_users") array_push($appliedUsers, new UserApplicationResource($user));
                else if($column === "rejected_users") array_push($rejectedUsers, new UserApplicationResource($user));
                else if($column === "accepted_users") array_push($acceptedUsers, new UserApplicationResource($user));
            }
        }

        $info['not_applied_users'] = $notAppliedUsers;
        $info['applied_users'] = $appliedUsers;
        $info['rejected_users'] = $rejectedUsers;
        $info['accepted_users'] = $acceptedUsers;

        $step['info'] = $info;

        return new StepResourceForUser($step);
    }

    public function managementUsersInStep(ManagmentUsersRequest $request, string $userId)
    {   
        $step = $this->stepRepository->getStepById($request['id']);
        
        if(!isset($step)) throw new Exception("Etap nie isnieje!");
        
        $announcement = $this->announcementRepository->getAnnouncementByIdWhitoutExpiryDate($step['announcement_id']);
        $company = $this->companyRepository->getCompanyByUserId($userId);

        if($announcement['company_id'] !== $company['id']) throw new Exception("Brak uprawnień do zasobu!");
        if($step['is_active'] === null) throw new Exception("Etap nie został rozpoczęty!");

        $updatedStep = $this->stepRepository->managmentUsers($request);

        return $updatedStep;
    }
}