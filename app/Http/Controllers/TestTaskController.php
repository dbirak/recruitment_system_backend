<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTestRequest;
use App\Services\TestTaskService;
use Exception;
use Illuminate\Http\Request;

class TestTaskController extends Controller
{
    protected $testTaskService;

    public function __construct(TestTaskService $testTaskService)
    {
        $this->testTaskService = $testTaskService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $res = $this->testTaskService->getAllTests($request->user()->id);
        return response($res, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddTestRequest $request)
    {
        $res = $this->testTaskService->createTest($request);
        return response($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        try
        {
            $res = $this->testTaskService->showTest($id, $request->user()->id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 404);
        }
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
    public function destroy(string $taskId, Request $request)
    {
        try
        {
            $res = $this->testTaskService->deleteTestTask($taskId, $request->user()->id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 409);
        }
    }
}
