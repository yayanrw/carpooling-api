<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(StoreUserRequest $storeUserRequest)
    {
        try {
            $storeUserRequest->validated($storeUserRequest->all());

            $user = User::create([
                'name' => $storeUserRequest->name,
                'email' => $storeUserRequest->email,
                'password' => Hash::make($storeUserRequest->password),
            ]);

            return $this->success([
                'user' => $user,
            ]);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }



    public function login(LoginUserRequest $loginUserRequest)
    {
        try {
            $loginUserRequest->validate($loginUserRequest->all());

            if (!Auth::attempt($loginUserRequest->only(['email', 'password']))) {
                return $this->error(null, 'Email or Password is incorrect', 401);
            }

            $user = User::where('email', $loginUserRequest->email)->first();

            if ($user->role == 'superuser') {
                $abilities = [
                    ''
                ];
            }

            if ($user->role == 'admin') {
                $abilities = [
                    ''
                ];
            }

            if ($user->role == 'enduser') {
                $abilities = [
                    ''
                ];
            }

            return $this->success([
                'user' => $user,
                'token' => $user->createToken($user->name . '\'s token', $abilities)->plainTextToken
            ]);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }
}
