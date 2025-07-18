<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

public function store(Request $request)
{
    $request->validate([
        'usuario' => 'required|string|max:255',
        'correo' => 'required|email|unique:usuarios,correo',
        'password' => 'required|string|min:8',
    ]);

    $idGenerado = $this->generarIdUnico();

    

    Usuario::create([
        'idUsuario' => $idGenerado,
        'usuario' => $request->usuario,
        'correo' => $request->correo,
        'password' => bcrypt($request->password),
        'activo' => $request->activo ?? 1
    ]);

    return redirect()->route('admin.usuarios.index')->with('success', 'Usuario registrado correctamente.');
}


    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'usuario' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo,' . $usuario->idUsuario . ',idUsuario',
        ]);

        $usuario->update([
            'usuario' => $request->usuario,
            'correo' => $request->correo,
                    'activo' => $request->activo,

        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    private function generarIdUnico()
{
    $ultimoId = Usuario::orderBy('idUsuario', 'desc')->first();
    
    if (!$ultimoId) {
        return 'U001';
    }

    $numero = intval(substr($ultimoId->idUsuario, 1)) + 1;
    return 'U' . str_pad($numero, 3, '0', STR_PAD_LEFT);
}

}
