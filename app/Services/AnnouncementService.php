<?php

namespace App\Services;

use App\Http\Requests\AddAnnouncementRequest;
use App\Http\Requests\SearchAnnouncementRequest;
use App\Http\Resources\AnnouncementCollection;
use App\Http\Resources\AnnouncementResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\EarnTimeResource;
use App\Http\Resources\FileTaskResource;
use App\Http\Resources\OpenTaskResource;
use App\Http\Resources\StepResourceForUser;
use App\Http\Resources\TestTaskResource;
use App\Http\Resources\WorkTimeResource;
use App\Http\Resources\WorkTypeResource;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Company;
use App\Models\WorkType;
use App\Repositories\AnnouncementRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ContractRepository;
use App\Repositories\EarnTimeRepository;
use App\Repositories\FileTaskRepository;
use App\Repositories\OpenTaskRepository;
use App\Repositories\StepRepository;
use App\Repositories\TestTaskRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkTimeRepository;
use App\Repositories\WorkTypeRepository;
use Carbon\Carbon;
use Exception;
use PhpParser\JsonDecoder;

use function PHPUnit\Framework\isEmpty;

class AnnouncementService {

    protected $announcementRepository;
    protected $companyRepository;
    protected $stepRepository;
    protected $appliactionRepository;

    protected $categoryRepository;
    protected $contractRepository;
    protected $workTimeRepository;
    protected $workTypeRepository;
    protected $earnTimeRepository;

    protected $testTaskRepository;
    protected $openTaskRepository;
    protected $fileTaskRepository;

    public function __construct(AnnouncementRepository $announcementRepository, CompanyRepository $companyRepository, StepRepository $stepRepository, CategoryRepository $categoryRepository, ContractRepository $contractRepository, WorkTimeRepository $workTimeRepository, WorkTypeRepository $workTypeRepository, EarnTimeRepository $earnTimeRepository, TestTaskRepository $testTaskRepository, OpenTaskRepository $openTaskRepository, FileTaskRepository $fileTaskRepository, ApplicationRepository $appliactionRepository)
    {
        $this->announcementRepository = $announcementRepository;
        $this->companyRepository = $companyRepository;
        $this->stepRepository = $stepRepository;
        $this->appliactionRepository = $appliactionRepository;

        $this->categoryRepository = $categoryRepository;
        $this->contractRepository = $contractRepository;
        $this->workTimeRepository = $workTimeRepository;
        $this->workTypeRepository = $workTypeRepository;
        $this->earnTimeRepository = $earnTimeRepository;

        $this->testTaskRepository = $testTaskRepository;
        $this->openTaskRepository = $openTaskRepository;
        $this->fileTaskRepository = $fileTaskRepository;
    }

    public function getCreateAnnoucementInfo()
    {
        $res['categories'] = CategoryResource::collection($this->categoryRepository->getAllCategories());
        $res['contracts'] = ContractResource::collection($this->contractRepository->getAllContracts());
        $res['workTimes'] = WorkTimeResource::collection($this->workTimeRepository->getAllWorkTimes());
        $res['workTypes'] = WorkTypeResource::collection($this->workTypeRepository->getAllWorkTypes());
        return $res;
    }

    public function getCreateAnnoucementEarnTimeInfo()
    {
        return EarnTimeResource::collection($this->earnTimeRepository->getAllEarnTimes());
    }

    public function getCreateAnnoucementModuleInfo(string $userId)
    {
        $res['tests'] = TestTaskResource::collection($this->testTaskRepository->getAllUserTestTask($userId));
        $res['openTasks'] = OpenTaskResource::collection($this->openTaskRepository->getAllUserOpenTask($userId));
        $res['fileTasks'] = FileTaskResource::collection($this->fileTaskRepository->getAllUserFileTask($userId));

        return $res;
    }

    public function createAnnouncement(AddAnnouncementRequest $request, string $userId)
    {
        $company = $this->companyRepository->getCompanyByUserId($userId);

        $annoucement = $this->announcementRepository->createAnnouncement($request, $company['id']);

        $steps = $this->stepRepository->createStep($request, $annoucement['id']);

        return $annoucement;
    }

    public function getPopularAnnouncement()
    {
        return AnnouncementResource::collection($this->announcementRepository->getPopularAnnouncement());
    }

    public function showAnnouncement(string $id)
    {
        $annoucement = $this->announcementRepository->getAnnouncementById($id);

        if(!isset($annoucement)) throw new Exception("Nie znaleziono ogłoszenia!");

        return new AnnouncementResource($annoucement);
    }

    public function searchAnnouncement(SearchAnnouncementRequest $request)
    {
        return new AnnouncementCollection($this->announcementRepository->searchAnnouncement($request));
    }

    public function showApplicationInfo(string $announcementId, string $userId)
    {
        $steps = $this->stepRepository->getStepsFromAnnouncement($announcementId);
        $applicationUser = $this->appliactionRepository->getAllUserApplication($userId, $announcementId);
        $res = $this->announcementRepository->getAnnouncementByIdWhitoutExpiryDate($announcementId);

        if($res === null) throw new Exception("Nie znaleziono ogłoszenia!");

        //whitout application but announcement is active
        if(count($applicationUser) === 0 && $res['expiry_date'] >= Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d'))
        {
            return new AnnouncementResource($res);
        }
        //without application and announcement is out of date
        else if(count($applicationUser) === 0 && $res['expiry_date'] < Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d'))
        {
            throw new Exception("Nie znaleziono ogłoszenia");
        }
        //with application
        else if(count($applicationUser) !== 0)
        {
            //return new AnnouncementResource($res);

            $stepsArray = [];
            $isRejected = false;

            foreach ($steps as $step)
            {
                $isActualStep = $this->isActualStep($step['expiry_date']);
                $answerInfo = null;

                $application = null;
                $statusInfo = in_array($userId, json_decode($step['applied_users'])) ? "applied_user" : (in_array($userId, json_decode($step['rejected_users'])) ? "rejected_user" : (in_array($userId, json_decode($step['accepted_users'])) ? "accepted_user" : null));

                $application = $this->appliactionRepository->getApplicationById($userId, $announcementId, $step['id']);

                if($isRejected) $answerInfo = null;
                else if($application === null && $isActualStep === false) $answerInfo = "not_sended";
                else if($application !== null && $isActualStep === false) $answerInfo = "sended";
                else if($application === null && $isActualStep === null) $answerInfo = null;
                else if($application !== null && $isActualStep === true) $answerInfo = "sended";
                else if($application === null && $isActualStep === true)
                {
                    if($step['step_number'] >= 2)
                    {
                        $previousStep = $steps[$step["step_number"] - 2];
                        if(in_array($userId, json_decode($previousStep['accepted_users']))) 
                        {
                            $answerInfo = "send_now";
                        }
                        else $answerInfo = null;
                    }
                    else $answerInfo = "sended";
                }

                $stepInfo['answer_info'] = $answerInfo;
                $stepInfo['status_info'] = $statusInfo;
                $step['info'] = $stepInfo;

                $step['expiry_date'] = $isRejected ? null : $step['expiry_date'];

                array_push($stepsArray, new StepResourceForUser($step));

                if($statusInfo === "rejected_user") $isRejected = true;
            }
            
            $res['steps'] = $stepsArray;

            return new AnnouncementResource($res);
        }

        throw new Exception("Nie znaleziono ogłoszenia");
    }

    public function isActualStep($expieryDate)
    {
        if($expieryDate >= Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d')) return true;
        else if($expieryDate === null) return null; 
        else if($expieryDate < Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d')) return false;
    }

    public function getCompanyAnnouncements(string $userId)
    {
        return new AnnouncementCollection($this->announcementRepository->getCompanyAnnouncements($userId));
    }

    public function getCompanyAnnouncementById(string $id, string $userId)
    {
        $res = $this->announcementRepository->getAnnouncementByIdWhitoutExpiryDate($id);
        $company = $this->companyRepository->getCompanyByUserId($userId);

        if(!isset($res)) throw new Exception("Nie znaleziono ogłoszenia!");
        if($res['company_id'] !== $company['id']) throw new Exception("Ogłoszenie nie należy do firmy!");

        $steps = $this->stepRepository->getStepsFromAnnouncement($res['id']);

        $stepsArray = [];
        
        foreach ($steps as $step)
        {
            $taskInfo = null;
            $applicationInfo = null;
            $canSetExpiryDate = false;

            $appliedUsersCount = count(json_decode($step['applied_users']));
            $rejectedUsersCount = count(json_decode($step['rejected_users']));
            $acceptedUsersCount = count(json_decode($step['accepted_users']));

            if($step['task_id'] ===  1) $taskInfo = $this->testTaskRepository->getUserTestTaskById($step['test_task_id']); 
            else if($step['task_id'] ===  2) $taskInfo = $this->openTaskRepository->getOpenTaskById($step['open_task_id'])[0]; 
            else if($step['task_id'] ===  3) $taskInfo = $this->fileTaskRepository->getFileTaskById($step['file_task_id'])[0]; 
            else if($step['task_id'] ===  4) $taskInfo = null;
            
            if($step['is_active'] === null) $applicationInfo = null;    
            else if($step['is_active'] === 0) $applicationInfo = "see_answers";
            else if($step['is_active'] === 1) $applicationInfo = "manage_answers";

            if($step['expiry_date'] === null && $steps[$step['step_number']-2] !== null && $steps[$step['step_number']-2]['expiry_date'] < Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d')) $canSetExpiryDate = true; 

            $stats['applied_users_count'] = $appliedUsersCount; 
            $stats['rejected_users_count'] = $rejectedUsersCount; 
            $stats['accepted_users_count'] = $acceptedUsersCount; 
            $stepInfo['stats'] = $stats;
            $stepInfo['task_info'] = $taskInfo;
            $stepInfo['application_info'] = $applicationInfo;
            $stepInfo['can_change_expiry_date_info'] = $canSetExpiryDate;
            $step['info'] = $stepInfo;

            array_push($stepsArray, new StepResourceForUser($step));
        }

        $res['steps'] = $stepsArray;

        return new AnnouncementResource($res);
    }
}