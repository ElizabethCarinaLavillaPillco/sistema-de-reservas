<?php

namespace App\Http\Controllers;

use App\Models\TourReserva;
use App\Models\Reserva;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourReservaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'tour_id' => 'nullable|exists:tours,id',
            'fecha' => 'nullable|date',
            'empresa' => 'nullable|string',
            'tipo_tour' => 'required|in:Grupal,Privado',
            'idioma' => 'nullable|string',
            'lugar_recojo' => 'nullable|string',
            'hora_recojo' => 'nullable|string',
            'precio_unitario' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'observaciones' => 'nullable|string',
            'incluye_entrada' => 'boolean',
            'incluye_tren' => 'boolean',
        ]);

        $tourReserva = TourReserva::create($request->all());

        // Detectar si es un tour Machupicchu especial
        if ($this->esMachupicchuEspecial($request->input('tour_id'))) {
            $tourReserva->detalleMachupicchu()->create([
                'tipo_entrada' => $request->input('tipo_entrada'),
                'horario_entrada' => $request->input('horario_entrada'),
                'tipo_tren' => $request->input('tipo_tren'),
                'empresa_tren' => $request->input('empresa_tren'),
                'codigo_tren' => $request->input('codigo_tren'),
                'horario_ida' => $request->input('horario_ida'),
                'horario_retorno' => $request->input('horario_retorno'),
                'fecha_tren_ida' => $request->input('fecha_tren_ida'),
                'fecha_tren_retorno' => $request->input('fecha_tren_retorno'),
                'hospedaje' => $request->input('hospedaje'),
            ]);
        }

        return back()->with('success', 'Tour agregado a la reserva.');
    }


    
    private function esMachupicchuEspecial($tourId)
    {
        $nombresEspeciales = [
            'Machupicchu Full Day',
            'Machupicchu Conexión',
            'Machupicchu 2D/1N',
            'Machupicchu By car'
        ];

        $tour = \App\Models\Tour::find($tourId);
        return $tour && in_array($tour->nombre_tour, $nombresEspeciales);
    }


    public function update(Request $request, $id)
    {
        $tourReserva = TourReserva::findOrFail($id);

        $request->validate([
            'tour_id' => 'nullable|exists:tours,id',
            'fecha' => 'nullable|date',
            'empresa' => 'nullable|string',
            'tipo_tour' => 'required|in:Grupal,Privado',
            'idioma' => 'nullable|string',
            'lugar_recojo' => 'nullable|string',
            'hora_recojo' => 'nullable|string',
            'precio_unitario' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'observaciones' => 'nullable|string',
            'incluye_entrada' => 'boolean',
            'incluye_tren' => 'boolean',
        ]);

        $tourReserva->update($request->all());

        return back()->with('success', 'Tour actualizado correctamente.');
    }

    public function destroy($id)
    {
        $tourReserva = TourReserva::findOrFail($id);
        $tourReserva->delete();

        return back()->with('success', 'Tour eliminado de la reserva.');
    }
}
