<?php

namespace App\Services;

use App\Http\Requests\AddCvTaskAnswerRequest;
use App\Http\Requests\AddFileTaskRequest;
use App\Http\Resources\FileTaskResource;
use App\Models\FileTask;
use App\Repositories\ApplicationRepository;
use App\Repositories\FileTaskRepository;
use App\Repositories\StepRepository;
use Exception;

class ApplicationService {

    protected $applicationRepository;
    protected $stepRepository;

    public function __construct(ApplicationRepository $applicationRepository, StepRepository $stepRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->stepRepository = $stepRepository;
    }

    public function storeCvTaskAnswer(AddCvTaskAnswerRequest $request)
    {
        $steps = $this->stepRepository->getStepsFromAnnouncement($request['announcement_id']);

        return $this->applicationRepository->createCvTaskAnswer($request, $steps[0]);
    }
}