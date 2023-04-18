<?php

namespace App\Repositories;

use App\Http\Requests\RegisterUserRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
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
            'role_id' => $request['rola']
        ]);

        return $user;
    }
}