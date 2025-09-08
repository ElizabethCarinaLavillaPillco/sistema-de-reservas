<?php

namespace App\Http\Controllers;

use App\Models\Pasajero;
use App\Models\Reserva;
use App\Models\Tour;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PasajeroController extends Controller
{
    public function index()
    {
        $pasajeros = Pasajero::with('reserva')->paginate(10);
        
        return view('admin.pasajeros.index', compact('pasajeros'));
    }

    public function create()
    {
        $reservas = Reserva::all();
        return view('admin.pasajeros.create', compact('reservas'));
    }

    public function show($id)
    {
        $pasajero = Pasajero::with('reserva')->findOrFail($id);
        return view('admin.pasajeros.show', compact('pasajero'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reserva_id' => 'nullable|exists:reservas,id',
            'documento' => 'required|string|max:50',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'pais_nacimiento' => 'required|string|max:100',
            'pais_residencia' => 'required|string|max:100',
            'ciudad' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'nullable|string|max:20',
            'tipo_pasajero'   => 'required|string|max:50', // 👈 sin espacio
            'tipo_documento'  => 'required|string|max:50'
        ]);

        $pasajero = new Pasajero($validated);

        // Asignar tarifa automáticamente
        //$pasajero->tarifa = $this->asignarTarifa($request);

        $pasajero->save();

        return redirect()->route('admin.pasajeros.index')->with('success', 'Pasajero registrado correctamente.');
    }

    public function edit(Pasajero $pasajero)
    {
        $reservas = Reserva::all();
        return view('admin.pasajeros.edit', compact('pasajero', 'reservas'));
    }

    public function update(Request $request, Pasajero $pasajero)
    {
        $validated = $request->validate([
            'reserva_id' => 'nullable|exists:reservas,id',
            'documento' => 'required|string|max:50',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'pais_nacimiento' => 'required|string|max:100',
            'pais_residencia' => 'required|string|max:100',
            'ciudad' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'nullable|string|max:20',
            'tipo_pasajero'   => 'required|string|max:50', // 👈 sin espacio
            'tipo_documento'  => 'required|string|max:50'
        ]);

        $pasajero->fill($validated);

        // Reasignar tarifa si cambió algo
        //$pasajero->tarifa = $this->asignarTarifa($request);

        $pasajero->save();

        return redirect()->route('admin.pasajeros.index')->with('success', 'Pasajero actualizado correctamente.');
    }

    public function destroy(Pasajero $pasajero)
    {
        $pasajero->delete();
        return redirect()->route('admin.pasajeros.index')->with('success', 'Pasajero eliminado correctamente.');
    }

}
