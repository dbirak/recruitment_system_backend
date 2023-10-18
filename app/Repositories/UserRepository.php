<?php

namespace App\Repositories;

use App\Http\Requests\RegisterUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function comparePassword(string $password, User $user)
    {
        return Hash::check($password, $user->password);
    }

    public function createToken(User $user)
    {
        return $user->createToken('token', [Role::find($user->role_id)->role_name])->plainTextToken;
    }

    public function deleteToken(Request $request)
    {
        $request->user()->tokens()->delete();
    }

    public function create(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request['imię'],
            'surname' => $request['nazwisko'],
            'email' => $request['email'],
            'password' => bcrypt($request['hasło']),
            'role_id' => 1
        ]);

        return $user;
    }

    public function getUserById($userId)
    {
        return $this->user::where("id", $userId)->first();
    }

    public function changePassword(String $password, User $user)
    {
        $user->password = bcrypt($password);
        $user->save();
    }

    public function findResetPasswordUsers(string $email)
    {
        return DB::table("password_reset_tokens")->where('email', $email)->first();
    }

    public function deleteResetPasswordUser($user)
    {
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
    }

    public function createForgotPasswordToken(string $token, string $email)
    {
        DB::table('password_reset_tokens')->insert([
            'email' => $email, 
            'token' => $token
        ]);
    }

    public function findByResetToken(string $token)
    {
        return DB::table('password_reset_tokens')->where('token', $token)->first();
    }
}