<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'user_name'    => 'required|string|max:255',
            'user_email'   => 'required|email|unique:users,email',
            'user_password'=> 'required|string|min:6',
        ]);

        // Cria a empresa
        $company = Company::create([
            'name' => $request->company_name,
        ]);

        // Cria o primeiro usuário associado à empresa
        $user = User::create([
            'company_id' => $company->id,
            'name'       => $request->user_name,
            'email'      => $request->user_email,
            'password'   => Hash::make($request->user_password),
        ]);

        // Autentica automaticamente
        $token = auth()->login($user);

        return response()->json([
            'message'       => 'Empresa e usuário criados com sucesso.',
            'access_token'  => $token,
            'user'          => $user,
            'company'       => $company,
        ], 201);
    }
}
