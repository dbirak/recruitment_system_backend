<?php

namespace App\Services;

use App\Http\Requests\TaskUserInformationRequest;
use App\Http\Resources\AnswerQuestionForUserResource;
use App\Http\Resources\FileTaskResource;
use App\Http\Resources\OpenTaskResource;
use App\Repositories\AnnouncementRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\FileTaskRepository;
use App\Repositories\OpenTaskRepository;
use App\Repositories\StepRepository;
use App\Repositories\SubmissionLockRepository;
use App\Repositories\TestTaskRepository;
use Exception;

class TaskService {

    protected $testTaskRepository;
    protected $openTaskRepository;
    protected $fileTaskRepository;

    protected $stepRepository;
    protected $announcementRepository;
    protected $applicationRepository;

    protected $submissionLockRepository;

    public function __construct(TestTaskRepository $testTaskRepository, OpenTaskRepository $openTaskRepository, FileTaskRepository $fileTaskRepository, StepRepository $stepRepository, AnnouncementRepository $announcementRepository, SubmissionLockRepository $submissionLockRepository, ApplicationRepository $applicationRepository)
    {
        $this->testTaskRepository = $testTaskRepository;
        $this->openTaskRepository = $openTaskRepository;
        $this->fileTaskRepository = $fileTaskRepository;
        $this->stepRepository = $stepRepository;
        $this->announcementRepository = $announcementRepository;
        $this->submissionLockRepository = $submissionLockRepository;
        $this->applicationRepository = $applicationRepository;
    }

    public function getTaskInfo(TaskUserInformationRequest $request, string $userId)
    {
        $step = $this->stepRepository->getStepById($request['id']);
        $allSteps = $this->stepRepository->getStepsFromAnnouncement($request['announcement_id']);
        
        if(!in_array($userId, json_decode($allSteps[$step['step_number'] - 2]['accepted_users']))) throw new Exception("Nie masz uprawnień do zasoubu!");

        $chcekApplication = $this->applicationRepository->getApplicationById($userId, $request['announcement_id'], $request['id']);
        if(isset($chcekApplication)) throw new Exception("Odpowiedź już została przesłana!");

        $checkSubmissionLock = $this->submissionLockRepository->getSubmissionLock($request['id'], $userId);
        if(isset($checkSubmissionLock)) throw new Exception("Odpowiedź już została rozpoczęta!");

        $this->submissionLockRepository->createSubmissionLock($request['id'], $userId);
        
        if($step['task_id'] === 1)
        {
            $res['task_info'] = $this->testTaskRepository->getUserTestTaskById($step['test_task_id'])[0];
            $res['task_info']['questions_count'] = $this->testTaskRepository->getCountQuesitionFromTest($step['test_task_id']);
            $res['task_details'] = AnswerQuestionForUserResource::collection($this->testTaskRepository->getTestById($step['test_task_id']));
        }
        if($step['task_id'] === 2)
        {
            $res['task_info'] = new OpenTaskResource($this->openTaskRepository->getOpenTaskById($step['open_task_id'])[0]);
            $res['task_details'] = $this->openTaskRepository->getOpenTaskById($step['open_task_id'])[0];
        }
        if($step['task_id'] === 3)
        {
            $res['task_info'] = new FileTaskResource($this->fileTaskRepository->getFileTaskById($step['file_task_id'])[0]);
            $res['task_details'] = $this->fileTaskRepository->getFileTaskById($step['file_task_id'])[0];
        }

        return $res;
    }

    public function storeTaskAnswer($request, string $userId)
    {
        dd(true);
    }
}