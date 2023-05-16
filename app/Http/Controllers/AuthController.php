<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
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
}
