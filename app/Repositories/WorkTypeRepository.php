<?php

namespace App\Repositories;

use App\Models\WorkType;

class WorkTypeRepository {

    protected $workType;

    public function __construct(WorkType $workType)
    {
        $this->workType = $workType;
    }

    public function getAllWorkTypes()
    {
        return $this->workType::all();
    }
}