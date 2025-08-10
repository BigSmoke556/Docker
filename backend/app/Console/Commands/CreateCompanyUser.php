<?php

namespace App\Console\Commands;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Console\Command;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateCompanyUser extends Command
{
    protected $signature = 'make:company-user
                            {companyName : Nome da empresa}
                            {userName : Nome do usuário}
                            {userEmail : Email do usuário}
                            {userPassword : Senha do usuário}';

    protected $description = 'Cria uma nova empresa e um usuário vinculado a ela com JWT token';

    public function handle()
    {
        $companyName = $this->argument('companyName') ?? $this->ask('Nome da empresa');
        $userName = $this->argument('userName') ?? $this->ask('Nome do usuário');
        $userEmail = $this->argument('userEmail') ?? $this->ask('Email do usuário');
        $userPassword = $this->argument('userPassword') ?? $this->secret('Senha do usuário');
        $existingCompany = Company::where('name', $companyName)->first();
        if ($existingCompany) {
            $this->error("Já existe uma empresa com esse nome.");
            return 1;
        }

        // Verifica se email de usuário já está em uso
        $existingUser = User::where('email', $userEmail)->first();
        if ($existingUser) {
            $this->error("Já existe um usuário com esse e-mail.");
            return 1;
        }

        // Cria empresa
        $company = Company::create(['name' => $companyName]);

        // Cria usuário vinculado
        $user = User::create([
            'company_id' => $company->id,
            'name'       => $userName,
            'email'      => $userEmail,
            'password'   => Hash::make($userPassword),
        ]);

        // Gera o token JWT
        $token = JWTAuth::fromUser($user);

        $this->info("Empresa '{$company->name}' criada com ID {$company->id}");
        $this->info("Usuário '{$user->name}' criado e vinculado à empresa.");
        $this->info("Token JWT de autenticação:");
        $this->line($token);

        return 0;
    }
}
