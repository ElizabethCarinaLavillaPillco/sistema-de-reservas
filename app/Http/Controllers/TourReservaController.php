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
            'hora_recojo' => 'nullable|date',
            'precio_unitario' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'observaciones' => 'nullable|string',
            'incluye_entrada' => 'boolean',
            'incluye_tren' => 'boolean',
        ]);

        $tourReserva = TourReserva::create($request->only([
            'reserva_id', 'tour_id', 'fecha', 'empresa', 'tipo_tour',
            'idioma', 'lugar_recojo', 'hora_recojo', 'precio_unitario',
            'cantidad', 'observaciones', 'incluye_entrada', 'incluye_tren'
        ]));

        $tour = $tourReserva->tour;

        if ($tour && $tour->esMachupicchuEspecial() && $request->has('detalles_machu')) {
            $tourReserva->detalleMachupicchu()->create($request->detalles_machu);
        }

        if ($tour && $tour->esBoletoTuristico() && $request->has('detalles_boleto')) {
            $tourReserva->detalleBoletoTuristico()->create($request->detalles_boleto);
        }



        return back()->with('success', 'Tour agregado a la reserva.');
    }


    public function update(Request $request, $id)
    {
        $tourReserva->update($request->only([
            'tour_id', 'fecha', 'empresa', 'tipo_tour',
            'idioma', 'lugar_recojo', 'hora_recojo',
            'precio_unitario', 'cantidad', 'observaciones',
            'incluye_entrada', 'incluye_tren'
        ]));

        $tour = $tourReserva->tour;

        if ($tour && $tour->esMachupicchuEspecial() && $request->has('detalles_machu')) {
            if ($tourReserva->detalleMachupicchu) {
                $tourReserva->detalleMachupicchu->update($request->detalles_machu);
            } else {
                $tourReserva->detalleMachupicchu()->create($request->detalles_machu);
            }
        }

        if ($tour && $tour->esBoletoTuristico() && $request->has('detalles_boleto')) {
            if ($tourReserva->detalleBoletoTuristico) {
                $tourReserva->detalleBoletoTuristico->update($request->detalles_boleto);
            } else {
                $tourReserva->detalleBoletoTuristico()->create($request->detalles_boleto);
            }
        }


        

        return back()->with('success', 'Tour actualizado correctamente.');
    }


    public function destroy($id)
    {
        $tourReserva = TourReserva::findOrFail($id);
        $tourReserva->delete();

        return back()->with('success', 'Tour eliminado de la reserva.');
    }
}
