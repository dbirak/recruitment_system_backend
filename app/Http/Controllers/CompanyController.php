<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\SearchCompanyRequest;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\Request;
use Laravel\Sail\Console\AddCommand;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
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
    public function update(UpdateCompanyProfileRequest $request)
    {
        try
        {
            $res = $this->companyService->updateCompanyProfile($request, $request->user()->id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getCompanyProfile(Request $request)
    {
        try
        {
            $res = $this->companyService->getCompanyProfile($request->user()->id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    public function showCompanyProfileForUser(string $id)
    {
        try
        {
            $res = $this->companyService->showCompanyProfileForUser($id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 404);
        }
    }

    public function getCompanyAnnouncements(string $id)
    {
        try
        {
            $res = $this->companyService->getCompanyAnnouncements($id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    public function getCompanyComments(string $id)
    {
        try
        {
            $res = $this->companyService->getCompanyComments($id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    public function getCompanyCommentsForUsers(string $id, Request $request)
    {
        try
        {
            $res = $this->companyService->getCompanyCommentsForUsers($id, $request->user()->id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    public function storeCompanyComment(AddCommentRequest $request)
    {
        try
        {
            $res = $this->companyService->storeCompanyComment($request, $request->user()->id);
            return response($res, 201);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    public function updateCompanyComment(string $id, AddCommentRequest $request)
    {
        try
        {
            $res = $this->companyService->updateCompanyComment($request, $request->user()->id, $id);
            return response($res, 201);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    public function destroyCompanyComment(string $id, Request $request)
    {
        try
        {
            $res = $this->companyService->destroyCompanyComment($request->user()->id, $id);
            return response($res, 204);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 400);
        }
    }

    public function searchCompany(SearchCompanyRequest $request)
    {
        $res = $this->companyService->searchCompany($request);
        return response($res, 200);
    }

    public function getStatistics(Request $request)
    {
        $res = $this->companyService->getStatistics($request->user()->id);
        return response($res, 200);
    }
}
