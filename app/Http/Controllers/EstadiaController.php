<?php

namespace App\Http\Controllers;

use App\Models\Estadia;
use App\Models\Reserva;
use Illuminate\Http\Request;

class EstadiaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'tipo_estadia' => 'required|in:Hostal,Hospedaje,Airbnb',
            'nombre_estadia' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'fecha' => 'nullable|date',
            'habitacion' => 'nullable|string|max:255',
        ]);

        Estadia::create($request->all());

        return back()->with('success', 'Estadía agregada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $estadia = Estadia::findOrFail($id);

        $request->validate([
            'tipo_estadia' => 'required|in:Hostal,Hospedaje,Airbnb',
            'nombre_estadia' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'fecha' => 'nullable|date',
            'habitacion' => 'nullable|string|max:255',
        ]);

        $estadia->update($request->all());

        return back()->with('success', 'Estadía actualizada correctamente.');
    }

    public function destroy($id)
    {
        $estadia = Estadia::findOrFail($id);
        $estadia->delete();

        return back()->with('success', 'Estadía eliminada correctamente.');
    }
}
