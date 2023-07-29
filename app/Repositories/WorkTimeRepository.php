<?php

namespace App\Repositories;

use App\Models\WorkTime;

class WorkTimeRepository {

    protected $workTime;

    public function __construct(WorkTime $workTime)
    {
        $this->workTime = $workTime;
    }

    public function getAllWorkTimes()
    {
        return $this->workTime::all();
    }
}