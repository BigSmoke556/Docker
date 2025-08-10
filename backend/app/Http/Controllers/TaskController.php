<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Task::where('company_id', $user->company_id);

        // Filtros
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        return response()->json($query->orderByDesc('id')->get());
    }

    public function show($id)
    {
        return response()->json(Task::findOrFail($id));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $task = Task::create([
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pendente',
            'priority' => $request->priority ?? 'média',
            'due_date' => $request->due_date,
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->only(['title', 'description', 'status', 'priority', 'due_date']));
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Tarefa excluída']);
    }
}