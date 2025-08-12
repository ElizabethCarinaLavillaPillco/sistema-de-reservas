<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Pasajero;
use App\Models\Proveedor;
use App\Models\Tour;
use App\Models\ToursReserva;
use App\Models\DetallesTourMachupicchu;
use App\Models\Estadia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
        public function index()
    {
        $reservas = Reserva::with(['proveedor', 'pasajeros'])->get();
        return view('admin.reservas.index', compact('reservas'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $pasajeros   = Pasajero::all();
        $tours       = Tour::all();

        return view('admin.reservas.create', compact('proveedores', 'pasajeros', 'tours'));
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
            // Crear la reserva principal
            $data       = $request->all();
            $data['id'] = Str::uuid();
            $reserva    = Reserva::create($data);

            // Guardar Tours asociados
            if ($request->has('tours') && is_array($request->tours)) {
                foreach ($request->tours as $tourData) {
                    $tourReserva = ToursReserva::create([
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

                    // Si es tour de Machupicchu, guardamos detalles
                    if (isset($tourData['detalles_machu'])) {
                        DetallesTourMachupicchu::create(array_merge(
                            $tourData['detalles_machu'],
                            ['tours_reserva_id' => $tourReserva->id]
                        ));
                    }
                }
            }

            // Guardar Estadías asociadas
            if ($request->has('estadias') && is_array($request->estadias)) {
                foreach ($request->estadias as $estadiaData) {
                    Estadia::create([
                        'reserva_id'    => $reserva->id,
                        'tipo_estadia'  => $estadiaData['tipo_estadia'] ?? 'Hostal',
                        'nombre_estadia'=> $estadiaData['nombre_estadia'] ?? '',
                        'ubicacion'     => $estadiaData['ubicacion'] ?? null,
                        'fecha'         => $estadiaData['fecha'] ?? null,
                        'habitacion'    => $estadiaData['habitacion'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva creada correctamente.');
    }

    public function show($id)
    {
        $reserva = Reserva::with([
            'proveedor',
            'pasajeros',
            'toursEscritos.detallesMachupicchu',
            'estadias.hotel', // si estadía tiene relación con hotel
            'depositos',
            'facturaciones.detalles' // si facturación tiene detalles
        ])->findOrFail($id);

        return view('admin.reservas.show', compact('reserva'));
    }


    public function edit($id)
    {
        $reserva     = Reserva::with(['toursEscritos.detallesMachupicchu', 'estadias'])->findOrFail($id);
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

            // Eliminar relaciones viejas y volver a guardar
            ToursReserva::where('reserva_id', $reserva->id)->delete();
            Estadia::where('reserva_id', $reserva->id)->delete();

            if ($request->has('tours') && is_array($request->tours)) {
                foreach ($request->tours as $tourData) {
                    $tourReserva = ToursReserva::create([
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

                    if (isset($tourData['detalles_machu'])) {
                        DetallesTourMachupicchu::create(array_merge(
                            $tourData['detalles_machu'],
                            ['tours_reserva_id' => $tourReserva->id]
                        ));
                    }
                }
            }

            if ($request->has('estadias') && is_array($request->estadias)) {
                foreach ($request->estadias as $estadiaData) {
                    Estadia::create([
                        'reserva_id'    => $reserva->id,
                        'tipo_estadia'  => $estadiaData['tipo_estadia'] ?? 'Hostal',
                        'nombre_estadia'=> $estadiaData['nombre_estadia'] ?? '',
                        'ubicacion'     => $estadiaData['ubicacion'] ?? null,
                        'fecha'         => $estadiaData['fecha'] ?? null,
                        'habitacion'    => $estadiaData['habitacion'] ?? null,
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

