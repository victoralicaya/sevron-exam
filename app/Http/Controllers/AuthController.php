<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * User Registratioin
     *
     * @param UserRegisterRequest $request
     */
    public function register(UserRegisterRequest $request)
    {
        User::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'User created successfully.'
        ], 201);
    }

    /**
     * User Authenticaiton
     *
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token
            ], 200);
        }

        return response()->json([
            'status' => false,
            'error' => 'Invalid username or password'
        ], 401);
    }

    /**
     * User logout
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User logged out.'
        ], 200);
    }
}
