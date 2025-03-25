<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validated)
        {
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            return response()->json([
                'message' => 'User created successfully!'
            ]);
        } else
        {
            return response()->json([
                'message' => 'Failed to create user! Validation failed!'
            ], 422);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if (auth()->attempt($credentials)) {
            $user = User::where('email', $request['email'])->firstOrFail();
            $authToken = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'access_token' => $authToken,
                'token_type' => 'Bearer',
                'user' => $user, // Field password is hidden
            ]);

        } else {
            return response()->json([
                'message' => 'The given data was invalid!',
            ], 422);
        }
    }
}
