<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Pasajero;
use App\Models\DetalleTourBoletoTuristico;
use App\Models\Proveedor;
use App\Models\Tour;
use App\Models\ToursReserva;
use App\Models\ToursInclude;
use App\Models\Facturacion;
use App\Models\DetalleTourMachupicchu;
use App\Models\Estadia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $hoy = Carbon::today();

        $proximasReservas = Reserva::whereDate('fecha_llegada', '>=', $hoy)
            ->orderBy('fecha_llegada', 'asc')
            ->get();

        $reservas = Reserva::with(['proveedor', 'pasajeros', 'toursReserva']);

        if ($request->filled('search')) {
            $busqueda = $request->search;
            $reservas->whereHas('titular', function ($q) use ($busqueda) {
                $q->where(DB::raw("CONCAT(nombre,' ',apellido)"), 'LIKE', "%{$busqueda}%");
            });
        }

        if ($request->filled('estado_pago')) {
            $reservas->where('estado_pago', $request->estado_pago);
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
            $fin = Carbon::parse($request->fecha_fin)->endOfDay();

            $reservas->where(function ($q) use ($inicio, $fin) {
                $q->whereBetween('fecha_llegada', [$inicio, $fin])
                  ->orWhereBetween('fecha_salida', [$inicio, $fin])
                  ->orWhereHas('toursReserva', function ($q2) use ($inicio, $fin) {
                      $q2->whereBetween('fecha', [$inicio, $fin]);
                  });
            });
        }

        if ($request->get('entrantes') == 1) {
            $reservas->whereDate('fecha_llegada', '>=', $hoy);
        }

        $reservas = $reservas->orderBy('fecha_llegada', 'asc')->paginate(10);

        return view('admin.reservas.index', compact('reservas', 'proximasReservas'));
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
            'cantidad_depositos'  => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $data       = $request->all();
            $data['id'] = $this->generarCodigoReserva();
            $reserva    = Reserva::create($data);

            if ($request->filled('pasajeros')) {
                Pasajero::whereIn('id', $request->pasajeros)
                    ->update(['reserva_id' => $reserva->id]);
            }

            if ($request->has('tours')) {
                $this->syncTours($reserva, $request->tours, $request);
            }
            
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

            if ($request->has('depositos') && is_array($request->depositos)) {
                foreach ($request->depositos as $depositoData) {
                    // Solo crear si hay algún dato importante
                    if (!empty($depositoData['monto']) || !empty($depositoData['nombre_depositante'])) {
                        $reserva->depositos()->create([
                            'nombre_depositante' => $depositoData['nombre_depositante'] ?? null,
                            'monto'              => $depositoData['monto'] ?? 0,
                            'fecha'              => $depositoData['fecha'] ?? null,
                            'tipo_deposito'      => $depositoData['tipo_deposito'] ?? null,
                            'observaciones'      => $depositoData['observaciones'] ?? null,
                        ]);
                    }
                }
            }

            // Actualizar resumen de pagos
            $adelanto = $reserva->depositos()->sum('monto');
            $reserva->adelanto = $adelanto;
            $reserva->cantidad_depositos = $reserva->depositos()->count();
            $reserva->save();


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
            'toursReserva.detalleMachupicchu',
            'toursReserva.detalleBoletoTuristico',
            'toursReserva.pasajeros',
            'toursReserva.includes',
            'estadias',
            'depositos',
            'facturaciones'
        ])->findOrFail($id);

        return view('admin.reservas.show', compact('reserva'));
    }

    public function edit($id)
    {
        $reserva= Reserva::with([
            'toursReserva.detalleMachupicchu',
            'toursReserva.detalleBoletoTuristico',
            'toursReserva.pasajeros',
            'toursReserva.includes',
            'estadias',
            'depositos'
        ])->findOrFail($id);

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
            'cantidad_depositos' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($request, $id) {
            $reserva = Reserva::findOrFail($id);
            $reserva->update($request->all());

            // 🔹 Limpiar datos relacionados que se recrean
            //ToursReserva::where('reserva_id', $reserva->id)->delete();
            Estadia::where('reserva_id', $reserva->id)->delete();
            $reserva->depositos()->delete(); // ✅ evita duplicados

            // 🔹 Actualizar pasajeros
            if ($request->filled('pasajeros')) {
                Pasajero::whereIn('id', $request->pasajeros)
                    ->update(['reserva_id' => $reserva->id]);
            }

            // 🔹 Guardar tours
            if ($request->has('tours')) {
                $this->syncTours($reserva, $request->tours, $request);
            }

            // 🔹 Guardar estadías
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

            // 🔹 Guardar depósitos
            if ($request->has('depositos') && is_array($request->depositos)) {
                foreach ($request->depositos as $depositoData) {
                    if (!empty($depositoData['monto']) || !empty($depositoData['nombre_depositante'])) {
                        $reserva->depositos()->create([
                            'nombre_depositante' => $depositoData['nombre_depositante'] ?? null,
                            'monto'              => $depositoData['monto'] ?? 0,
                            'fecha'              => $depositoData['fecha'] ?? null,
                            'tipo_deposito'      => $depositoData['tipo_deposito'] ?? null,
                            'observaciones'      => $depositoData['observaciones'] ?? null,
                        ]);
                    }
                }
            }

            // 🔹 Actualizar resumen de pagos
            $reserva->adelanto = $reserva->depositos()->sum('monto');
            $reserva->cantidad_depositos = $reserva->depositos()->count();
            $reserva->save();
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

    private function syncTours(Reserva $reserva, array $toursData, Request $request)
    {
        foreach ($toursData as $tourData) {
            if (empty($tourData['tour_id'])) continue;

            $toursReserva = ToursReserva::updateOrCreate(
                ['id' => $tourData['id'] ?? null],
                [
                    'reserva_id'      => $reserva->id,
                    'tour_id'         => $tourData['tour_id'] ?? null,
                    'fecha'           => $tourData['fecha'] ?? null,
                    'empresa'         => $tourData['empresa'] ?? null,
                    'tipo_tour'       => $tourData['tipo_tour'] ?? 'Grupal',
                    'idioma'          => $tourData['idioma'] ?? null,
                    'lugar_recojo'    => $tourData['lugar_recojo'] ?? null,
                    'hora_recojo'     => $tourData['hora_recojo'] ?? null,
                    'precio_unitario' => $tourData['precio_unitario'] ?? 0,
                    'cantidad'        => $tourData['cantidad'] ?? 1,
                    'observaciones'   => $tourData['observaciones'] ?? null,
                    'incluye_entrada' => !empty($tourData['incluye_entrada']),
                    'incluye_tren'    => !empty($tourData['incluye_tren']),
                ]
            );

            // 🔹 Machupicchu / Boleto turístico
            if ($this->esMachupicchuEspecial($tourData['tour_id'] ?? null) && isset($tourData['detalles_machu'])) {
                $toursReserva->detalleMachupicchu()
                    ->updateOrCreate([], $tourData['detalles_machu']);
            }
            if (!empty($tourData['detalles_boleto']) && $this->esBoletoTuristico($tourData['tour_id'])) {
                $toursReserva->detalleBoletoTuristico()
                    ->updateOrCreate([], $tourData['detalles_boleto']);
            }

            $modo = $request->modo[$toursReserva->id] ?? 'todos';
            $syncData = [];

            if ($modo === 'todos') {
                foreach ($reserva->pasajeros as $p) {
                    $syncData[$p->id] = [
                        'incluido'   => true,
                        'comentario' => null
                    ];
                }
            } else {
                $pasajerosSeleccionados = $request->pasajeros[$toursReserva->id] ?? [];
                $comentarios            = $request->comentarios[$toursReserva->id] ?? [];

                foreach ($pasajerosSeleccionados as $idPasajero) {
                    $syncData[$idPasajero] = [
                        'incluido'   => true,
                        'comentario' => $comentarios[$idPasajero] ?? null
                    ];
                }
            }

            $toursReserva->pasajeros()->sync($syncData);

            // ========================================
            // 🔹 Guardar includes del tour
            // ========================================
            $incluye = $request->includes[$toursReserva->id] ?? [];
            $toursReserva->includes()->delete();
            foreach ($incluye as $concepto) {
                $toursReserva->includes()->create([
                    'concepto' => $concepto,
                    'incluido' => true
                ]);
            }

        }
    }

}
