<?php

namespace App\Services;

use App\Http\Requests\AddAnnouncementRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\EarnTimeResource;
use App\Http\Resources\FileTaskResource;
use App\Http\Resources\OpenTaskResource;
use App\Http\Resources\TestTaskResource;
use App\Http\Resources\WorkTimeResource;
use App\Http\Resources\WorkTypeResource;
use App\Models\Category;
use App\Models\WorkType;
use App\Repositories\AnnouncementRepository;
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

class AnnouncementService {

    protected $announcementRepository;
    protected $companyRepository;
    protected $stepRepository;

    protected $categoryRepository;
    protected $contractRepository;
    protected $workTimeRepository;
    protected $workTypeRepository;
    protected $earnTimeRepository;

    protected $testTaskRepository;
    protected $openTaskRepository;
    protected $fileTaskRepository;

    public function __construct(AnnouncementRepository $announcementRepository, CompanyRepository $companyRepository, StepRepository $stepRepository, CategoryRepository $categoryRepository, ContractRepository $contractRepository, WorkTimeRepository $workTimeRepository, WorkTypeRepository $workTypeRepository, EarnTimeRepository $earnTimeRepository, TestTaskRepository $testTaskRepository, OpenTaskRepository $openTaskRepository, FileTaskRepository $fileTaskRepository)
    {
        $this->announcementRepository = $announcementRepository;
        $this->companyRepository = $companyRepository;
        $this->stepRepository = $stepRepository;

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

        $steps = $this->stepRepository->createStep($request, $company['id']);

        return $annoucement;
    }
}