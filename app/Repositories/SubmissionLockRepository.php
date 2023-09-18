<?php

namespace App\Repositories;

use App\Models\SubmissionLock;

class SubmissionLockRepository {

    protected $submissionLock;

    public function __construct(SubmissionLock $submissionLock)
    {
        $this->submissionLock = $submissionLock;
    }

    public function createSubmissionLock(string $stepId, string $userId)
    {
        $newSubmissionLock = new SubmissionLock();
        $newSubmissionLock->step_id = $stepId;
        $newSubmissionLock->user_id = $userId;
        $newSubmissionLock->save();
    }

    public function getSubmissionLock(string $stepId, string $userId)
    {
        return $this->submissionLock::where('step_id', $stepId)->where('user_id', $userId)->first();
    }
}