<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function registerUser(RegisterUserRequest $request)
    {
        try 
        {
            $res = $this->authService->registerUser($request);
            return response($res, 200);
        } 
        catch(Exception $e)
        {
            return response(['message' => $e->getMessage()], 422);
        }
    }

    public function registerCompany(RegisterCompanyRequest $request)
    {
        try 
        {
            $res = $this->authService->registerCompany($request);
            return response($res, 200);
        } 
        catch(Exception $e)
        {
            return response(['message' => $e->getMessage()], 422);
        }
    }

    public function login(LoginUserRequest $request)
    {
        try 
        {
            $res = $this->authService->loginUser($request);
            return response($res, 200);
        } 
        catch(Exception $e)
        {
            if($e instanceof AuthenticationException)
                return response(['message' => 'Nieprawidłowy adres email lub hasło!'], 401);
        }
    }

    public function logout(Request $request)
    {   
        $res = $this->authService->logoutUser($request);
        return response($res, 200);
    }
}
