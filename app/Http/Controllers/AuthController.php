<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // check who register (1-user, 2-company)
        if($request['role_id'] == 1) {
            $data = $request->validate([
                'imię' => 'required|string|max:30|regex:/^[a-zA-ZĄ-ŻĄąĆćĘęŁłŃńÓóŚśŹźŻż _-]{1,}$/',
                'nazwisko' => 'required|string|max:30|regex:/^[a-zA-ZĄ-ŻĄąĆćĘęŁłŃńÓóŚśŹźŻż _-]{1,}$/',
                'email' => 'required|string|unique:users|email|max:30',
                'hasło' => 'required|string|min:8',
            ]);

            if($data['hasło'] !== $request['powtórz hasło']) return response()->json(["errors" => ["powtórz hasło" => ["Podane hasła nie są takie same"]]], 422);
    
            $user = User::create([
                'name' => $data['imię'],
                'surname' => $data['nazwisko'],
                'email' => $data['email'],
                'password' => bcrypt($data['hasło']),
                'role_id' => $request['role_id']
            ]);
    
            $token = $user->createToken('token', [Role::find($request['role_id'])->role_name])->plainTextToken;
    
            $res = [
                'user' => $user,
                'token' => $token
            ];
            return response($res, 201);
        }
        if($request['role_id'] == 2) {
            //To do
        }

        abort(404);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'message' => 'incorrect username or password'
            ], 401);
        }

        $token = $user->createToken('token', [Role::find($user->role_id)->role_name])->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];

        return response($res, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
