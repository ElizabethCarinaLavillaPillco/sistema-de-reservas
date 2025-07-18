<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UsuarioApiController extends Controller
{
    // Listar todos los usuarios
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // Registrar un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'usuario' => $request->usuario,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'reestablecer' => false,
            'activo' => true,
        ]);

        return response()->json(['message' => 'Usuario creado', 'usuario' => $user], 201);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->only(['usuario', 'correo', 'activo', 'reestablecer']));

        return response()->json(['message' => 'Usuario actualizado', 'usuario' => $user]);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado']);
    }


public function login(Request $request)
{
    $request->validate([
        'correo' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('correo', $request->correo)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }

    $token = $user->createToken('token_acceso')->plainTextToken;

    return response()->json([
        'message' => 'Login exitoso',
        'token' => $token,
        'usuario' => $user
    ]);
}

}

