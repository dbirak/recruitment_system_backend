<?php

namespace App\Http\Controllers;

use App\Services\CvTaskService;
use Exception;
use Illuminate\Http\Request;

class CvTaskController extends Controller
{
    protected $cvTaskService;

    public function __construct(CvTaskService $cvTaskService)
    {
        $this->cvTaskService = $cvTaskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getCvAnswer(string $fileName)
    {
        try
        {
            $res = $this->cvTaskService->showCvAnswer($fileName);
            return $res;
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 404);
        }
    }
}
