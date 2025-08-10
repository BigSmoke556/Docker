<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Task;
use Illuminate\Http\Request;

class EnsureTaskBelongsToUserCompany
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        $task = Task::find($request->route('id'));

        if (!$task || $task->company_id !== auth()->user()->company_id) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        return $next($request);
    }
}
