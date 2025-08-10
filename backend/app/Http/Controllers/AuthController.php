<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name'       => 'required|string',
            'email'      => 'required|string|email|unique:users',
            'password'   => 'required|string|min:6'
        ]);

        $user = User::create([
            'company_id' => $request->company_id,
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password)
        ]);

        $token = auth()->login($user);

        return response()->json([
            'access_token' => $token,
            'user' => auth()->user(),
            'company' => $user->company->name
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'user' => auth()->user(),
            'company' => auth()->user()->company->name
        ]);
    }

    public function me()
    {
        return response()->json([
            'user' => auth()->user(),
            'company' => auth()->user()->company->name
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logout successful']);
    }
}