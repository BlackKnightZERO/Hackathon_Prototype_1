<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
	
	use HttpResponses;

    public function login(LoginRequest $request)
    {
        $request->validated($request->only(['email', 'password']));

        if(!auth()->attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::with('role.permissions.module')->where('email', $request->email)->first();
        $permission = $user->role->permissions;
        // $user = User::where('email', $request->email)->first();
        // $permission = $user->role->permissions;

        return $this->success([
            'user'          => $user,
            'token'         => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated($request->only(['first_name', 'last_name', 'email', 'username', 'phone', 'password']));

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' 	=> $request->email,
            'username' 	=> $request->username,
            'phone' 	=> $request->phone,
            'password' 	=> Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        auth('web')->logout();
        auth()->user()->tokens()->delete();

        return $this->success([
            'message' => 'You have succesfully been logged out and your token has been removed'
        ]);
    }
}
