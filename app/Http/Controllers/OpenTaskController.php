<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOpenTaskRequest;
use App\Services\OpenTaskService;
use Exception;
use Illuminate\Http\Request;

class OpenTaskController extends Controller
{
    protected $openTaskService;

    public function __construct(OpenTaskService $openTaskService)
    {
        $this->openTaskService = $openTaskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $res = $this->openTaskService->getAllOpenTasks($request->user()->id);
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
    public function store(AddOpenTaskRequest $request)
    {
        $res = $this->openTaskService->createOpenTask($request);
        return response($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        try
        {
            $res = $this->openTaskService->showOpenTask($id, $request->user()->id);
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
    public function destroy(string $id)
    {
        //
    }
}
