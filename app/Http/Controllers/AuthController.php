<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        try {
            $request->validated($request->all());

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return $this->success([
                'user' => $user,
            ]);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }
}
