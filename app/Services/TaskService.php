<?php

namespace App\Services;

use App\Http\Requests\TaskUserAnswerRequest;
use App\Http\Requests\TaskUserInformationRequest;
use App\Http\Resources\AnswerQuestionForUserResource;
use App\Http\Resources\FileTaskResource;
use App\Http\Resources\OpenTaskResource;
use App\Models\FileAnswer;
use App\Models\OpenAnswer;
use App\Models\TestAnswer;
use App\Models\TestAnswerAnswer;
use App\Repositories\AnnouncementRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\FileTaskRepository;
use App\Repositories\OpenTaskRepository;
use App\Repositories\StepRepository;
use App\Repositories\SubmissionLockRepository;
use App\Repositories\TestTaskRepository;
use DateInterval;
use DateTime;
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

    public function storeTaskAnswer(TaskUserAnswerRequest $request, string $userId)
    {
        $newApplication = true;

        $step = $this->stepRepository->getStepById($request['id']);
        $allSteps = $this->stepRepository->getStepsFromAnnouncement($request['announcement_id']);
        
        if(!in_array($userId, json_decode($allSteps[$step['step_number'] - 2]['accepted_users']))) throw new Exception("Nie masz uprawnień do zasoubu!");

        $chcekApplication = $this->applicationRepository->getApplicationById($userId, $request['announcement_id'], $request['id']);
        if(isset($chcekApplication)) throw new Exception("Odpowiedź już została przesłana!");

        $checkSubmissionLock = $this->submissionLockRepository->getSubmissionLock($request['id'], $userId);
        if(!isset($checkSubmissionLock)) throw new Exception("Odpowiedź nie została rozpoczęta!");

        if($step['task_id'] === 1)
        {
            $task = $this->testTaskRepository->getUserTestTaskById($step['test_task_id'])[0];
        }
        if($step['task_id'] === 2)
        {
            $task = new OpenTaskResource($this->openTaskRepository->getOpenTaskById($step['open_task_id'])[0]);
        }
        if($step['task_id'] === 3)
        {
            $task = new FileTaskResource($this->fileTaskRepository->getFileTaskById($step['file_task_id'])[0]);
        }

        // Timestamp in format "2023-09-18 19:46:45"
        $timestamp = $checkSubmissionLock['created_at'];
        $currentDateTime = new DateTime();
        
        // Add task time to timestamp
        $timestamp->add(new DateInterval('PT'.$task['time'].'M'));
        $timestamp->add(new DateInterval('PT3M'));
        
        
        if ($currentDateTime > $timestamp) {
            throw new Exception("Nie można już przesłać odpowiedzi!");
        }

        //store task
        if($step['task_id'] === 1)
        {
            $taskAnswer = $this->testTaskRepository->createTestAnswer($request);
        }
        if($step['task_id'] === 2)
        {
            $taskAnswer = $this->openTaskRepository->createOpenAnswer($request);
        }
        if($step['task_id'] === 3 && $request['answer'] !== "null")
        {
            $taskAnswer = $this->fileTaskRepository->createFileAnswer($request);
        }
        
        if($request['answer'] !== "null") 
        {
            $newApplication = $this->applicationRepository->createApplication($step, $userId, $taskAnswer);
            $this->submissionLockRepository->removeSubmissionLockById($checkSubmissionLock['id']);
            $this->stepRepository->addNewAppliedToStep($step['id'], $userId);
        }

        return $newApplication;
    }
}   