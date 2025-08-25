<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Pasajero;
use App\Models\DetalleTourBoletoTuristico;
use App\Models\Proveedor;
use App\Models\Tour;
use App\Models\TourReserva;
use App\Models\DetalleTourMachupicchu;
use App\Models\Estadia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $reservas = Reserva::with(['proveedor', 'pasajeros'])->get();
        return view('admin.reservas.index', compact('reservas'));

    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $pasajeros   = Pasajero::all();
        $tours       = Tour::all();
        
        $pasajerosSinReserva = Pasajero::whereNull('reserva_id')->get();
        return view('admin.reservas.create', compact('proveedores', 'pasajeros', 'tours','pasajerosSinReserva'));
        
    }

    private function generarCodigoReserva()
    {
        $ultimo = Reserva::orderBy('id', 'desc')->first();
        if (!$ultimo) {
            return 'R00001';
        }
        $numero = intval(substr($ultimo->id, 1)) + 1;
        return 'R' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }


    public function store(Request $request)
    {
        $request->validate([
            'tipo_reserva'       => 'required|in:Directo,Recomendacion,Publicidad,Agencia',
            'proveedor_id'       => 'nullable|exists:proveedores,id',
            'titular_id'         => 'required|exists:pasajeros,id',
            'fecha_llegada'      => 'nullable|date',
            'hora_llegada'       => 'nullable|string',
            'nro_vuelo_llegada'  => 'nullable|string',
            'fecha_salida'       => 'nullable|date',
            'hora_salida'        => 'nullable|string',
            'nro_vuelo_retorno'  => 'nullable|string',
            'cantidad_pasajeros' => 'required|integer|min:1',
            'cantidad_tours'     => 'required|integer|min:0',
            'cantidad_estadias'  => 'required|integer|min:0',
            'total'              => 'required|numeric|min:0',
            'adelanto'           => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Generar código y crear la reserva una sola vez
            $data       = $request->all();
            $data['id'] = $this->generarCodigoReserva();
            $reserva    = Reserva::create($data);

            // Asociar pasajeros
            if ($request->filled('pasajeros')) {
                Pasajero::whereIn('id', $request->pasajeros)
                    ->update(['reserva_id' => $reserva->id]);
            }

            // Guardar tours asociados
            if ($request->has('tours') && is_array($request->tours)) {
                foreach ($request->tours as $tourData) {

                    if (empty($tourData['tour_id'])) {
                        continue; // saltar si no hay tour_id
                    }

                    $tourReserva = TourReserva::create([
                        'reserva_id'       => $reserva->id,
                        'tour_id'          => $tourData['tour_id'] ?? null,
                        'fecha'            => $tourData['fecha'] ?? null,
                        'empresa'          => $tourData['empresa'] ?? null,
                        'tipo_tour'        => $tourData['tipo_tour'] ?? 'Grupal',
                        'idioma'           => $tourData['idioma'] ?? null,
                        'lugar_recojo'     => $tourData['lugar_recojo'] ?? null,
                        'hora_recojo'      => $tourData['hora_recojo'] ?? null,
                        'precio_unitario'  => $tourData['precio_unitario'] ?? 0,
                        'cantidad'         => $tourData['cantidad'] ?? 1,
                        'observaciones'    => $tourData['observaciones'] ?? null,
                        'incluye_entrada'  => !empty($tourData['incluye_entrada']),
                        'incluye_tren'     => !empty($tourData['incluye_tren']),
                    ]);

                    // Guardar detalles Machupicchu si aplica
                    if ($this->esMachupicchuEspecial($tourData['tour_id'] ?? null) && isset($tourData['detalles_machu'])) {
                        DetalleTourMachupicchu::create(array_merge(
                            $tourData['detalles_machu'],
                            ['tours_reserva_id' => $tourReserva->id]
                        ));
                    }

                    // Boleto turístico (Valle Sagrado, City Tour, etc.)
                    if (!empty($tourData['detalles_boleto']) && $this->esBoletoTuristico($tourData['tour_id'])) {
                        DetalleTourBoletoTuristico::create([
                            'tours_reserva_id' => $tourReserva->id,
                            'tipo_boleto'      => $tourData['detalles_boleto']['tipo_boleto']      ?? null,
                            'requiere_compra'  => $tourData['detalles_boleto']['requiere_compra']  ?? null,
                            'tipo_compra'      => $tourData['detalles_boleto']['tipo_compra']      ?? null,
                            'incluye_entrada_propiedad_priv'      => $tourData['detalles_boleto']['incluye_entrada_propiedad_priv']    ?? null,
                            'quien_compra_propiedad_priv'         => $tourData['detalles_boleto']['quien_compra_propiedad_priv']       ?? null,
                            'comentario_entrada_propiedad_priv'   => $tourData['detalles_boleto']['comentario_entrada_propiedad_priv'] ?? null,
                        ]);
                    }
                }
            }

            // Guardar estadías asociadas
            if ($request->has('estadias') && is_array($request->estadias)) {
                foreach ($request->estadias as $estadiaData) {
                    Estadia::create([
                        'reserva_id'     => $reserva->id,
                        'tipo_estadia'   => $estadiaData['tipo_estadia'] ?? 'Hostal',
                        'nombre_estadia' => $estadiaData['nombre_estadia'] ?? '',
                        'ubicacion'      => $estadiaData['ubicacion'] ?? null,
                        'fecha'          => $estadiaData['fecha'] ?? null,
                        'habitacion'     => $estadiaData['habitacion'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva creada correctamente.');
    }


    private function esMachupicchuEspecial($tourId)
    {
        $especiales = [
            'Machupicchu Full Day',
            'Machupicchu Conexión',
            'Machupicchu 2D/1N',
            'Machupicchu By car'
        ];

        $tour = Tour::find($tourId);
        return $tour && in_array($tour->nombreTour, $especiales);
    }

    private function esBoletoTuristico($tourId)
    {
        $especialesBoleto = [
            'Valle Sagrado',
            'City Tour',
            'Valle Sur',
            'Maras Moray',
            'Valle Sagrado VIP',
        ];

        $tour = Tour::find($tourId);
        return $tour && in_array($tour->nombreTour, $especialesBoleto);
    }

    public function show($id)
    {
        $reserva = Reserva::with([
            'proveedor',
            'pasajeros',
            'tourReserva.detalleMachupicchu',
            'tourReserva.detalleBoletoTuristico',
            'estadias',
            'depositos',
            'facturaciones.detalles'
        ])->findOrFail($id);

        return view('admin.reservas.show', compact('reserva'));
    }

    public function edit($id)
    {
        $reserva     = Reserva::with(['tourReserva.detalleMachupicchu', 'tourReserva.detalleBoletoTuristico','estadias'])->findOrFail($id);
        $proveedores = Proveedor::all();
        $pasajeros   = Pasajero::all();
        $tours       = Tour::all();

        return view('admin.reservas.edit', compact('reserva', 'proveedores', 'pasajeros', 'tours'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_reserva'       => 'required|in:Directo,Recomendacion,Publicidad,Agencia',
            'proveedor_id'       => 'nullable|exists:proveedores,id',
            'titular_id'         => 'required|exists:pasajeros,id',
            'fecha_llegada'      => 'nullable|date',
            'hora_llegada'       => 'nullable|string',
            'nro_vuelo_llegada'  => 'nullable|string',
            'fecha_salida'       => 'nullable|date',
            'hora_salida'        => 'nullable|string',
            'nro_vuelo_retorno'  => 'nullable|string',
            'cantidad_pasajeros' => 'required|integer|min:1',
            'cantidad_tours'     => 'required|integer|min:0',
            'cantidad_estadias'  => 'required|integer|min:0',
            'total'              => 'required|numeric|min:0',
            'adelanto'           => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $id) {
            $reserva = Reserva::findOrFail($id);
            $reserva->update($request->all());

            // Limpiar relaciones anteriores
            TourReserva::where('reserva_id', $reserva->id)->delete();
            Estadia::where('reserva_id', $reserva->id)->delete();
            

            // Guardar tours actualizados
            if ($request->has('tours') && is_array($request->tours)) {
                foreach ($request->tours as $tourData) {
                    if (empty($tourData['tour_id'])) {
                        continue; // saltar si no hay tour_id
                    }
                    $tourReserva = TourReserva::create([
                        'reserva_id'       => $reserva->id,
                        'tour_id'          => $tourData['tour_id'] ?? null,
                        'fecha'            => $tourData['fecha'] ?? null,
                        'empresa'          => $tourData['empresa'] ?? null,
                        'tipo_tour'        => $tourData['tipo_tour'] ?? 'Grupal',
                        'idioma'           => $tourData['idioma'] ?? null,
                        'lugar_recojo'     => $tourData['lugar_recojo'] ?? null,
                        'hora_recojo'      => $tourData['hora_recojo'] ?? null,
                        'precio_unitario'  => $tourData['precio_unitario'] ?? 0,
                        'cantidad'         => $tourData['cantidad'] ?? 1,
                        'observaciones'    => $tourData['observaciones'] ?? null,
                        'incluye_entrada'  => !empty($tourData['incluye_entrada']),
                        'incluye_tren'     => !empty($tourData['incluye_tren']),
                    ]);

                    if ($this->esMachupicchuEspecial($tourData['tour_id'] ?? null) && isset($tourData['detalles_machu'])) {
                        DetalleTourMachupicchu::create(array_merge(
                            $tourData['detalles_machu'],
                            ['tours_reserva_id' => $tourReserva->id]
                        ));
                    }

                    // Boleto turístico (Valle Sagrado, City Tour, etc.)
                    if (!empty($tourData['detalles_boleto']) && $this->esBoletoTuristico($tourData['tour_id'])) {
                        DetalleTourBoletoTuristico::create([
                            'tours_reserva_id' => $tourReserva->id,
                            'tipo_boleto'      => $tourData['detalles_boleto']['tipo_boleto']      ?? null,
                            'requiere_compra'  => $tourData['detalles_boleto']['requiere_compra']  ?? null,
                            'tipo_compra'      => $tourData['detalles_boleto']['tipo_compra']      ?? null,
                            'incluye_entrada_propiedad_priv'      => $tourData['detalles_boleto']['incluye_entrada_propiedad_priv']    ?? null,
                            'quien_compra_propiedad_priv'         => $tourData['detalles_boleto']['quien_compra_propiedad_priv']       ?? null,
                            'comentario_entrada_propiedad_priv'   => $tourData['detalles_boleto']['comentario_entrada_propiedad_priv'] ?? null,
                        ]);
                    }
                }
            }

            // Guardar estadías actualizadas
            if ($request->has('estadias') && is_array($request->estadias)) {
                foreach ($request->estadias as $estadiaData) {
                    Estadia::create([
                        'reserva_id'     => $reserva->id,
                        'tipo_estadia'   => $estadiaData['tipo_estadia'] ?? 'Hostal',
                        'nombre_estadia' => $estadiaData['nombre_estadia'] ?? '',
                        'ubicacion'      => $estadiaData['ubicacion'] ?? null,
                        'fecha'          => $estadiaData['fecha'] ?? null,
                        'habitacion'     => $estadiaData['habitacion'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva actualizada correctamente.');
    }

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva eliminada correctamente.');
    }
}
