<?php

namespace App\Http\Controllers;

use App\Models\ToursReserva;
use App\Models\Reserva;
use App\Models\Tour;
use Illuminate\Http\Request;

class ToursReservaController extends Controller
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

        $toursReserva = ToursReserva::create($request->only([
            'reserva_id', 'tour_id', 'fecha', 'empresa', 'tipo_tour',
            'idioma', 'lugar_recojo', 'hora_recojo', 'precio_unitario',
            'cantidad', 'observaciones', 'incluye_entrada', 'incluye_tren'
        ]));

        $tour = $toursReserva->tour;

        if ($tour && $tour->esMachupicchuEspecial() && $request->has('detalles_machu')) {
            $toursReserva->detalleMachupicchu()->create($request->detalles_machu);
        }

        if ($tour && $tour->esBoletoTuristico() && $request->has('detalles_boleto')) {
            $toursReserva->detalleBoletoTuristico()->create($request->detalles_boleto);
        }



        return back()->with('success', 'Tour agregado a la reserva.');
    }


    public function update(Request $request, $id)
    {
        $toursReserva->update($request->only([
            'tour_id', 'fecha', 'empresa', 'tipo_tour',
            'idioma', 'lugar_recojo', 'hora_recojo',
            'precio_unitario', 'cantidad', 'observaciones',
            'incluye_entrada', 'incluye_tren'
        ]));

        $tour = $toursReserva->tour;

        if ($tour && $tour->esMachupicchuEspecial() && $request->has('detalles_machu')) {
            if ($toursReserva->detalleMachupicchu) {
                $toursReserva->detalleMachupicchu->update($request->detalles_machu);
            } else {
                $toursReserva->detalleMachupicchu()->create($request->detalles_machu);
            }
        }

        if ($tour && $tour->esBoletoTuristico() && $request->has('detalles_boleto')) {
            if ($toursReserva->detalleBoletoTuristico) {
                $toursReserva->detalleBoletoTuristico->update($request->detalles_boleto);
            } else {
                $toursReserva->detalleBoletoTuristico()->create($request->detalles_boleto);
            }
        }


        

        return back()->with('success', 'Tour actualizado correctamente.');
    }


    public function destroy($id)
    {
        $toursReserva = ToursReserva::findOrFail($id);
        $toursReserva->delete();

        return back()->with('success', 'Tour eliminado de la reserva.');
    }
}
