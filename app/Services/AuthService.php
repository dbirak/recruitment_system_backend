<?php

namespace App\Services;

use App\Http\Mails\ResetPasswordMail;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        if($user['role_id'] === 2) return $this->returnCompanyWithToken($user, $token);
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

        return $this->returnCompanyWithToken($user, $token);
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

    public function returnCompanyWithToken($user, $token)
    {
        $res = [
            'data' => new UserResource($user),
            'token' => $token,
            'company' => new CompanyResource($this->companyRepository->getCompanyByUserId($user['id'])),
        ];

        return $res;
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = $this->userRepository->findResetPasswordUsers($request['email']);

        if($user) $this->userRepository->deleteResetPasswordUser($user);

        $token = Str::random(64);

        $this->userRepository->createForgotPasswordToken($token, $request['email']);

        $resetUrl = "http://localhost:3000/reset-password/".$token;

        Mail::to($request['email'])->send(new ResetPasswordMail($resetUrl));

        return $res = ['message' => "Link resetujący został wysłany na podany adres e-mail!"];
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = $this->userRepository->findByResetToken($request['token']);

        if(!$user) throw new Exception("Nie znaleziono użytkownika!");

        $user = $this->userRepository->findByEmail($user->email);

        $this->userRepository->changePassword($request['nowe hasło'], $user);

        $user = $this->userRepository->findResetPasswordUsers($user->email);

        if($user) $this->userRepository->deleteResetPasswordUser($user);

        return $res = ['message' => 'Hasło zostało zmienione!'];
    }

    public function ChangePasswordRequest(ChangePasswordRequest $request)
    {
        $user = $this->userRepository->getUserById($request->user()->id);

        if(!$this->userRepository->comparePassword($request['obecne hasło'], $user)) throw new Exception("Obecne hasło jest niepoprawne!");
        $this->userRepository->changePassword($request['nowe hasło'], $user);

        return $res = ['message' => 'Hasło zostało zmienione!'];
    }
}