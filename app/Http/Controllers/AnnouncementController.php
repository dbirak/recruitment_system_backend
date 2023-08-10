<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAnnouncementRequest;
use App\Services\AnnouncementService;
use App\Services\FileTaskService;
use App\Services\OpenTaskService;
use App\Services\TestTaskService;
use Exception;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    protected $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
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
    public function store(AddAnnouncementRequest $request)
    {
        $res = $this->announcementService->createAnnouncement($request, $request->user()->id);
        return response($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try
        {
            $res = $this->announcementService->showAnnouncement($id);
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

    public function getCreateAnnoucementInfo()
    {
        $res = $this->announcementService->getCreateAnnoucementInfo();
        return response($res, 200);
    }

    public function getCreateAnnoucementEarnTimeInfo()
    {
        $res = $this->announcementService->getCreateAnnoucementEarnTimeInfo();
        return response($res, 200);
    }

    public function getCreateAnnoucementModuleInfo(Request $request)
    {
        $res = $this->announcementService->getCreateAnnoucementModuleInfo($request->user()->id);
        return response($res, 200);
    }

    public function getPopularAnnouncement()
    {
        $res = $this->announcementService->getPopularAnnouncement();
        return response($res, 200);
    }
}
