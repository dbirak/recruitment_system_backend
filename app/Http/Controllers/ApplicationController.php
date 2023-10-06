<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCvTaskAnswerRequest;
use App\Http\Requests\ManagmentUsersRequest;
use App\Http\Requests\UserApplicationInfoRequest;
use App\Services\ApplicationService;
use Exception;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
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

    public function storeCvTaskAnswer(AddCvTaskAnswerRequest $request)
    {
        $res = $this->applicationService->storeCvTaskAnswer($request);
        return response($res, 201);
    }

    public function getUsersByStep(string $stepId, Request $request)
    {
        try
        {
            $res = $this->applicationService->getUsersByStep($stepId, $request->user()->id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    public function managementUsersInStep(ManagmentUsersRequest $request)
    {
        try
        {
            $res = $this->applicationService->managementUsersInStep($request, $request->user()->id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    public function getUserApplication(UserApplicationInfoRequest $request)
    {
        try
        {
            $res = $this->applicationService->getUserApplication($request);
            return response($res, 200);
        }
        catch(Exception $e)
        { 
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }
}
