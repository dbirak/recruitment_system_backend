<?php

namespace App\Repositories;

use App\Models\EarnTime;

class EarnTimeRepository {

    protected $earnTime;

    public function __construct(EarnTime $earnTime)
    {
        $this->earnTime = $earnTime;
    }

    public function getAllEarnTimes()
    {
        return $this->earnTime::all();
    }
}