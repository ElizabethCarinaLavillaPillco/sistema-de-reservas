<?php

namespace App\Http\Controllers;

use App\Models\Pasajero;
use App\Models\Reserva;
use Illuminate\Http\Request;

class PasajeroController extends Controller
{
    // Mostrar lista de pasajeros
    public function index()
    {
        $pasajeros = Pasajero::with('reserva.titular')->get();
        return view('admin.pasajeros.index', compact('pasajeros'));
    }

    // Formulario para crear pasajero
    public function create()
    {
        return view('admin.pasajeros.create'); // Sin lista de reservas
    }

    // Guardar nuevo pasajero
    public function store(Request $request)
    {
        $request->validate([
            'documento' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'pais_nacimiento' => 'required|string|max:255',
            'pais_residencia' => 'required|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'tarifa' => 'required|in:Adulto,Niño,Estudiante',
            'telefono' => 'nullable|string|max:255',
        ]);

        // Creamos pasajero sin asignar reserva todavía
        Pasajero::create($request->only([
            'documento',
            'nombre',
            'apellido',
            'pais_nacimiento',
            'pais_residencia',
            'ciudad',
            'fecha_nacimiento',
            'tarifa',
            'telefono'
        ]));

        return redirect()->route('admin.pasajeros.index')->with('success', 'Pasajero registrado con éxito.');
    }

    // Mostrar detalle de pasajero
    public function show($id)
    {
        $pasajero = Pasajero::with('reserva.titular')->findOrFail($id);
        return view('admin.pasajeros.show', compact('pasajero'));
    }

    // Formulario para editar pasajero
    public function edit($id)
    {
        $pasajero = Pasajero::findOrFail($id);
        return view('admin.pasajeros.edit', compact('pasajero')); // Sin lista de reservas
    }

    // Actualizar pasajero
    public function update(Request $request, $id)
    {
        $request->validate([
            'documento' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'pais_nacimiento' => 'required|string|max:255',
            'pais_residencia' => 'required|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'tarifa' => 'required|in:Adulto,Niño,Estudiante',
            'telefono' => 'nullable|string|max:255',
        ]);

        $pasajero = Pasajero::findOrFail($id);
        $pasajero->update($request->only([
            'documento',
            'nombre',
            'apellido',
            'pais_nacimiento',
            'pais_residencia',
            'ciudad',
            'fecha_nacimiento',
            'tarifa',
            'telefono'
        ]));

        return redirect()->route('admin.pasajeros.index')->with('success', 'Pasajero actualizado correctamente.');
    }

    // Eliminar pasajero
    public function destroy($id)
    {
        $pasajero = Pasajero::findOrFail($id);
        $pasajero->delete();

        return redirect()->route('admin.pasajeros.index')->with('success', 'Pasajero eliminado.');
    }
}
