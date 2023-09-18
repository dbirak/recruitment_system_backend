<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskUserInformationRequest;
use App\Services\TaskService;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
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

    public function getTaskInfo(TaskUserInformationRequest $request)
    {
        try
        {
            $res = $this->taskService->getTaskInfo($request, $request->user()->id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 404);
        }
    }

    public function storeTaskAnswer(Request $request)
    {
        try
        {
            $res = $this->taskService->storeTaskAnswer($request, $request->user()->id);
            return response($res, 201);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 404);
        }
    }
}
