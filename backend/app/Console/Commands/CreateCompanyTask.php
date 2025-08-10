<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class CreateCompanyTask extends Command
{
    protected $signature = 'company:create-task';
    protected $description = 'Cria uma nova task para uma empresa. Somente o primeiro usuário da empresa pode criar.';

    public function handle()
    {
        // 
        $email = $this->ask('Digite seu e-mail');
        $password = $this->secret('Digite sua senha');

        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            $this->error('Credenciais inválidas.');
            return;
        }

        // Verificar se é o primeiro usuário da empresa
        $firstUser = User::where('company_id', $user->company_id)
            ->orderBy('id')
            ->first();

        if ($firstUser->id !== $user->id) {
            $this->error('Apenas o primeiro usuário cadastrado da empresa pode criar tarefas.');
            return;
        }

    
        $title = $this->ask('Título da tarefa');
        $description = $this->ask('Descrição da tarefa');
        $priority = $this->choice('Prioridade', ['alta', 'media', 'baixa'], 0);


        $task = new Task();
        $task->title = $title;
        $task->description = $description;
        $task->priority = $priority;
        $task->user_id = $user->id;
        $task->company_id = $user->company_id;
        $task->save();

        $this->info('Tarefa criada com sucesso para a empresa!');
    }
}
