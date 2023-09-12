<?php

namespace App\Services;

use App\Http\Requests\AddCvTaskAnswerRequest;
use App\Http\Requests\AddFileTaskRequest;
use App\Http\Requests\ManagmentUsersRequest;
use App\Http\Requests\UserApplicationInfoRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\FileTaskResource;
use App\Http\Resources\StepResource;
use App\Http\Resources\StepResourceForUser;
use App\Http\Resources\UserApplicationResource;
use App\Models\FileTask;
use App\Repositories\AnnouncementRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\CvTaskRepository;
use App\Repositories\FileTaskRepository;
use App\Repositories\StepRepository;
use App\Repositories\UserRepository;
use Exception;
use GuzzleHttp\Psr7\Request;

class ApplicationService {

    protected $applicationRepository;
    protected $stepRepository;
    protected $companyRepository;
    protected $announcementRepository;
    protected $userRepository;
    protected $cvTaskRepository;

    public function __construct(ApplicationRepository $applicationRepository, StepRepository $stepRepository, CompanyRepository $companyRepository, AnnouncementRepository $announcementRepository, UserRepository $userRepository, CvTaskRepository $cvTaskRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->stepRepository = $stepRepository;
        $this->companyRepository = $companyRepository;
        $this->announcementRepository = $announcementRepository;
        $this->userRepository = $userRepository;
        $this->cvTaskRepository = $cvTaskRepository;
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
                $user = $this->userRepository->getUserById($userId);
                $user['have_answer'] = false;
                array_push($notAppliedUsers, new UserApplicationResource($user));
            }
        }

        foreach ($columnsName as $column)
        {
            foreach (json_decode($step[$column]) as $userId)
            {
                $user = $this->userRepository->getUserById($userId);
                $checkUserHaveAnswer = $this->applicationRepository->getApplicationById($userId, $announcement['id'], $stepId);

                $user['have_answer'] = isset($checkUserHaveAnswer) ? true : false;

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

    public function getUserApplication(UserApplicationInfoRequest $request)
    {
        $step = $this->stepRepository->getStepById($request['step_id']);    
        if(!isset($step)) throw new Exception("Etap nie isnieje!");
    
        $announcement = $this->announcementRepository->getAnnouncementByIdWhitoutExpiryDate($step['announcement_id']);

        $company = $this->companyRepository->getCompanyByUserId($request->user()->id);
        
        if($announcement['company_id'] !== $company['id']) throw new Exception("Brak uprawnień do zasobu!");
        if($step['is_active'] === null) throw new Exception("Etap nie został rozpoczęty!");

        $application = $this->applicationRepository->getUserApplication($request);
        $info = null;

        if($application['task_id'] === 1)
        {
            //
        }
        else if($application['task_id'] === 2)
        {
            //
        }
        else if($application['task_id'] === 3)
        {
            //
        }
        else if($application['task_id'] === 4)
        {
            $cvAnswer = $this->cvTaskRepository->getCvAnswerById($application['cv_answer_id']);
            $info = $cvAnswer;
        }

        $application['info'] = $info;

        return new ApplicationResource($application);
    }
}