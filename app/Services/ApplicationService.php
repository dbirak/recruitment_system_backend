<?php

namespace App\Services;

use App\Http\Requests\AddCvTaskAnswerRequest;
use App\Http\Requests\AddFileTaskRequest;
use App\Http\Resources\FileTaskResource;
use App\Http\Resources\StepResourceForUser;
use App\Models\FileTask;
use App\Repositories\AnnouncementRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\FileTaskRepository;
use App\Repositories\StepRepository;
use Exception;

class ApplicationService {

    protected $applicationRepository;
    protected $stepRepository;
    protected $companyRepository;
    protected $announcementRepository;

    public function __construct(ApplicationRepository $applicationRepository, StepRepository $stepRepository, CompanyRepository $companyRepository, AnnouncementRepository $announcementRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->stepRepository = $stepRepository;
        $this->companyRepository = $companyRepository;
        $this->announcementRepository = $announcementRepository;
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


        ///

        return new StepResourceForUser($step);
    }
}