<?php

// =============================================================================
// 🎮 CONTROLADOR: PasajeroController.php (SIMPLIFICADO)
// =============================================================================
namespace App\Http\Controllers;

use App\Models\Pasajero;
use App\Models\Reserva;
use Illuminate\Http\Request;

class PasajeroController extends Controller
{
    public function index()
    {
        $pasajeros = Pasajero::with('reservas')->paginate(20);
        return view('admin.pasajeros.index', compact('pasajeros'));
    }

    public function create()
    {
        return view('admin.pasajeros.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'documento' => 'required|string|max:50',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'pais_nacimiento' => 'required|string|max:100',
            'pais_residencia' => 'required|string|max:100',
            'ciudad' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'nullable|string|max:20',
            'tipo_pasajero' => 'required|in:Peruano,Extranjero,CAN',
            'tipo_documento' => 'required|in:DNI,CE,Pasaporte'
        ]);

        Pasajero::create($validated);

        return redirect()->route('admin.pasajeros.index')
            ->with('success', 'Pasajero registrado correctamente.');
    }

    public function show($id)
    {
        $pasajero = Pasajero::with('reservas')->findOrFail($id);
        return view('admin.pasajeros.show', compact('pasajero'));
    }

    public function edit($id)
    {
        $pasajero = Pasajero::findOrFail($id);
        $reservas = Reserva::with('titular')->get(); // ← Agrega esto
        return view('admin.pasajeros.edit', compact('pasajero', 'reservas'));
    }

    public function update(Request $request, $id)
    {
        $pasajero = Pasajero::findOrFail($id);

        $validated = $request->validate([
            'documento' => 'required|string|max:50',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'pais_nacimiento' => 'required|string|max:100',
            'pais_residencia' => 'required|string|max:100',
            'ciudad' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'nullable|string|max:20',
            'tipo_pasajero' => 'required|in:Peruano,Extranjero,CAN',
            'tipo_documento' => 'required|in:DNI,CE,Pasaporte'
        ]);

        $pasajero->update($validated);

        return redirect()->route('admin.pasajeros.index')
            ->with('success', 'Pasajero actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pasajero = Pasajero::findOrFail($id);
        
        // Verificar si es titular de alguna reserva
        if ($pasajero->reservasComoTitular()->exists()) {
            return back()->withErrors('No se puede eliminar: es titular de una reserva activa.');
        }

        $pasajero->delete();

        return redirect()->route('admin.pasajeros.index')
            ->with('success', 'Pasajero eliminado correctamente.');
    }
}