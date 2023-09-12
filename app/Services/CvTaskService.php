<?php

namespace App\Services;

use App\Repositories\CvTaskRepository;
use Illuminate\Support\Facades\Storage;

class CvTaskService {

    protected $cvTaskRepository;

    public function __construct(CvTaskRepository $cvTaskRepository)
    {
        $this->cvTaskRepository = $cvTaskRepository;
    }

    public function showCvAnswer(string $fileName)
    {
        if (Storage::exists('public/cv/'.$fileName)) {
            return Storage::response('public/cv/'.$fileName, $fileName, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $fileName . '"'
            ]);
        }
    }
}