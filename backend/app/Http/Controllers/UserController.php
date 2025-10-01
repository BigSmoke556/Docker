<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function response;

class UserController extends Controller
{
    // Listar todos os usuários
    public function index()
    {
        return response()->json(User::all());
    }

    // Criar novo usuário
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json($user, 201);
    }

    // Mostrar usuário específico
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    // Atualizar usuário
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));
        return response()->json($user);
    }

    // Excluir usuário
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Usuário excluído com sucesso']);
    }
}
