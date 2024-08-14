<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function me()
    {
        return response()->json([
            'user' => auth()->user(),
        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email|unique:users|max:255',
            'name' => 'bail|required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => $request->input('password'),
        ]);

        auth()->login($user);

        return response()->json([
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->input('email'))->firstOrFail();

        auth()->login($user);

        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function logout()
    {
        auth()->guard('web')->logout();

        return response()->json([], 204);
    }
}
