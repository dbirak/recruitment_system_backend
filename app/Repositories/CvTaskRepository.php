<?php

namespace App\Repositories;

use App\Models\CvAnswer;

class CvTaskRepository {

    protected $cvAnswer;

    public function __construct(CvAnswer $cvAnswer)
    {
        $this->cvAnswer = $cvAnswer;
    }

    public function getCvAnswerById(string $id)
    {
        return $this->cvAnswer::where('id', $id)->first();
    }
}