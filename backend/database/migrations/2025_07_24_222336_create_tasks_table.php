<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');      // Usuário criador da task
            $table->unsignedBigInteger('company_id');   // Empresa dona da task
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pendente', 'em andamento', 'concluida'])->default('pendente');
            $table->enum('priority', ['baixa', 'media', 'alta'])->default('media'); // SEM acento
            $table->date('due_date')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}