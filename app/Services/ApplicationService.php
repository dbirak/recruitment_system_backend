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
use App\Repositories\OpenTaskRepository;
use App\Repositories\StepRepository;
use App\Repositories\TestTaskRepository;
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
    protected $testTaskRepository;
    protected $openTaskRepository;
    protected $fileTaskRepository;

    public function __construct(ApplicationRepository $applicationRepository, StepRepository $stepRepository, CompanyRepository $companyRepository, AnnouncementRepository $announcementRepository, UserRepository $userRepository, CvTaskRepository $cvTaskRepository, TestTaskRepository $testTaskRepository, OpenTaskRepository $openTaskRepository, FileTaskRepository $fileTaskRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->stepRepository = $stepRepository;
        $this->companyRepository = $companyRepository;
        $this->announcementRepository = $announcementRepository;
        $this->userRepository = $userRepository;

        $this->cvTaskRepository = $cvTaskRepository;
        $this->testTaskRepository = $testTaskRepository;
        $this->openTaskRepository = $openTaskRepository;
        $this->fileTaskRepository = $fileTaskRepository;
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
            $mergeArray = array_merge($diff1, $diff2);

            $mergeArray = array_diff($mergeArray, json_decode($step['accepted_users']), json_decode($step['rejected_users']));

            foreach ($mergeArray as $userId)
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
            $testAnswers = $this->testTaskRepository->getTestAnswerById($application['test_answer_id']);

            $info = [];
           
            foreach ($testAnswers as $item) {
                $found = false;
                foreach ($info as &$resultItem) {
                    if ($resultItem['question_id'] === $item['question_id']) {
                        $resultItem['answers'][] = [
                            'answer' => $this->testTaskRepository->getAnswerById($item['answer_id'])['answer'],
                            'is_checked' => $item['is_checked'] === 1 ? true : false,
                            'is_correct' => $this->testTaskRepository->getAnswerById($item['answer_id'])['is_correct'] === 1 ? true : false
                        ];
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $info[] = [
                        'question_id' => $item['question_id'],
                        'question' => $this->testTaskRepository->getQuestionById($item['question_id'])['question'],
                        'answers' => [
                            [
                                'answer' => $this->testTaskRepository->getAnswerById($item['answer_id'])['answer'],
                                'is_checked' => $item['is_checked'] === 1 ? true : false,
                                'is_correct' => $this->testTaskRepository->getAnswerById($item['answer_id'])['is_correct'] === 1 ? true : false
                            ]
                        ]
                    ];
                }
            }

            foreach ($info as &$item)
            {
                $correctAnswer = true;

                foreach ($item['answers'] as $answer)
                {
                    if($answer['is_checked'] !== $answer['is_correct'])
                    {
                        $correctAnswer = false;
                        break;
                    }
                }

                $item['correct_answer'] = $correctAnswer;
            }
        }
        else if($application['task_id'] === 2)
        {
            $info = $this->openTaskRepository->getOpenAnswerById($application['open_answer_id']);
        }
        else if($application['task_id'] === 3)
        {
            $info = $this->fileTaskRepository->getFileAnswerById($application['file_answer_id']);
        }
        else if($application['task_id'] === 4)
        {
            $info = $this->cvTaskRepository->getCvAnswerById($application['cv_answer_id']);
        }

        $application['info'] = $info;

        return new ApplicationResource($application);
    }
}