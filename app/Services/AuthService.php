<?php

namespace App\Services;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\CompanyProfileResource;
use App\Http\Resources\UserResource;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthService {

    protected $userRepository;
    protected $companyRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    public function loginUser(LoginUserRequest $request) 
    {       
        $user = $this->userRepository->findByEmail($request['email']);
        
        if(!$user) $this->validateUser($user, "");
        
        $isCorrectPassword = $this->userRepository->comparePassword($request['hasło'], $user);

        $this->validateUser($user, $isCorrectPassword);
        
        $token = $this->createToken($user);

        return $this->returnUserWithToken($user, $token);
    }

    public function logoutUser(Request $request)
    {
        try
        {
            $this->userRepository->deleteToken($request);
            return $res = ['message' => 'Wylogowanie przebiegło pomyślnie!'];
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function registerUser(RegisterUserRequest $request)
    {
        $this->comparePasswordsFromRequest($request['hasło'], $request['powtórz hasło']);
        $user = $this->userRepository->create($request);
        $token = $this->createToken($user);

        return $this->returnUserWithToken($user, $token);
    }

    public function registerCompany(RegisterCompanyRequest $request)
    {
        $this->comparePasswordsFromRequest($request['hasło'], $request['powtórz hasło']);
        $user = $this->companyRepository->create($request);
        $token = $this->createToken($user);

        return $this->returnUserWithToken($user, $token);
    }

    public function createToken($user)
    {
        return $this->userRepository->createToken($user);
    }

    public function returnUserWithToken($user, $token)
    {
        $res = [
            'data' => new UserResource($user),
            'token' => $token
        ];

        return $res;
    }

    public function comparePasswordsFromRequest($passsword, $repeatPassword)
    {
        if($passsword !== $repeatPassword) throw new Exception('Podane hasła różnią się od siebie!');
    }

    public function validateUser($user, $isCorrectPassword)
    {
        if (!$user || !$isCorrectPassword) throw new AuthenticationException("Brak dostępu!");
    }

    public function getCompanyProfile(string $userId)
    {
        $company = $this->companyRepository->getCompanyByUserId($userId);

        $res = $this->companyRepository->getCompanyProfile($company['id']);

        if(!$res) throw new Exception("Przedsiębiorstwo nie istnieje!");

        return new CompanyProfileResource($res);
    }
}