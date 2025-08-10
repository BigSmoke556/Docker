<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyUserWizard extends Command
{
    // Nome do comando artisan:
    protected $signature = 'make:company-user-wizard';

    // Descrição do comando:
    protected $description = 'Cria empresas, usuários, ou ambos de forma interativa pelo console';

    public function handle()
    {
        $empresa = null;
        $empresaId = null;

        // Pergunta se o usuário deseja criar uma nova empresa
        if ($this->confirm('Deseja criar uma nova empresa?', true)) {
            $nomeEmpresa = $this->ask('Nome da empresa');
            if (Company::where('name', $nomeEmpresa)->exists()) {
                $this->error('Já existe uma empresa com esse nome.');
                return;
            }
            $empresa = Company::create(['name' => $nomeEmpresa]);
            $empresaId = $empresa->id;
            $this->info("empresa '{$empresa->name}' criada com ID {$empresa->id}");
        }

        // Pergunta se deseja cadastrar um usuário para alguma empresa
        if ($this->confirm('Deseja cadastrar um usuário para alguma empresa?', true)) {
            // Se não criou empresa agora, exibe as empresas existentes
            if (!$empresa) {
                $empresas = Company::pluck('name', 'id')->toArray();
                if (empty($empresas)) {
                    $this->error('Nenhuma empresa encontrada. Cadastre uma empresa primeiro.');
                    return;
                }
                $escolha = $this->choice(
                    'Escolha a empresa para vincular o usuário',
                    array_map(fn($id, $name) => "$id - $name", array_keys($empresas), $empresas)
                );
                // Extrai o ID antes do "-"
                $empresaId = (int) explode(' - ', $escolha)[0];
            }

            // Pede os dados do usuário
            $userName = $this->ask('Nome do usuário');
            $userEmail = $this->ask('Email do usuário');
            if (User::where('email', $userEmail)->exists()) {
                $this->error('Já existe um usuário com esse e-mail.');
                return;
            }
            $userPassword = $this->secret('Senha do usuário');
            $user = User::create([
                'company_id' => $empresaId,
                'name' => $userName,
                'email' => $userEmail,
                'password' => Hash::make($userPassword),
            ]);
            $this->info("Usuário '{$user->name}' criado e vinculado à empresa.");

            
            if (class_exists(JWTAuth::class)) {
                $token = JWTAuth::fromUser($user);
                $this->info("Token JWT do usuário: $token");
            }
        }

        $this->info('Processo finalizado!');
    }
}
