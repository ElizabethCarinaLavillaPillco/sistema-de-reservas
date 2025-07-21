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
        $pasajeros = Pasajero::with('reserva')->get();
        return view('admin.pasajeros.index', compact('pasajeros'));
    }

    // Formulario para crear pasajero
    public function create()
    {
        $reservas = Reserva::with('titular')->get();
        return view('admin.pasajeros.create', compact('reservas'));
    }

    // Guardar nuevo pasajero
    public function store(Request $request)
    {
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
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

        Pasajero::create($request->all());

        return redirect()->route('admin.pasajeros.index')->with('success', 'Pasajero registrado con éxito.');
    }

    // Mostrar detalle de pasajero
    public function show($id)
    {
        $pasajero = Pasajero::with('reserva')->findOrFail($id);
        return view('admin.pasajeros.show', compact('pasajero'));
    }

    // Formulario para editar pasajero
    public function edit($id)
    {
        $pasajero = Pasajero::findOrFail($id);
        $reservas = Reserva::with('titular')->get();
        return view('admin.pasajeros.edit', compact('pasajero', 'reservas'));
    }

    // Actualizar pasajero
    public function update(Request $request, $id)
    {
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
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
        $pasajero->update($request->all());

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
