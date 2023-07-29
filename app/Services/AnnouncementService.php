<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\WorkTimeResource;
use App\Http\Resources\WorkTypeResource;
use App\Models\Category;
use App\Models\WorkType;
use App\Repositories\CategoryRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ContractRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkTimeRepository;
use App\Repositories\WorkTypeRepository;

class AnnouncementService {

    protected $categoryRepository;
    protected $contractRepository;
    protected $workTimeRepository;
    protected $workTypeRepository;

    public function __construct(CategoryRepository $categoryRepository, ContractRepository $contractRepository, WorkTimeRepository $workTimeRepository, WorkTypeRepository $workTypeRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->contractRepository = $contractRepository;
        $this->workTimeRepository = $workTimeRepository;
        $this->workTypeRepository = $workTypeRepository;
    }

    public function getCreateAnnoucementInfo()
    {
        $res['categories'] = CategoryResource::collection($this->categoryRepository->getAllCategories());
        $res['contracts'] = ContractResource::collection($this->contractRepository->getAllContracts());
        $res['workTimes'] = WorkTimeResource::collection($this->workTimeRepository->getAllWorkTimes());
        $res['workTypes'] = WorkTypeResource::collection($this->workTypeRepository->getAllWorkTypes());
        return $res;
    }
}