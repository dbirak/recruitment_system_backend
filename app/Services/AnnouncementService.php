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
                $isActualStep = false;
                $answerInfo = null;

                $application = null;
                $statusInfo = in_array($userId, json_decode($step['applied_users'])) ? "applied_user" : (in_array($userId, json_decode($step['rejected_users'])) ? "rejected_user" : (in_array($userId, json_decode($step['accepted_users'])) ? "accepted_user" : null));

                if($step['expiry_date'] >= Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d')) $isActualStep = true;
                else if($step['expiry_date'] === null) $isActualStep = null; 
                else if($step['expiry_date'] < Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d')) $isActualStep = false;

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
}