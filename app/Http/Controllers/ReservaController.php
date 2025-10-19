<?php
// =============================================================================
// 🎮 CONTROLADOR: ReservaController.php
// =============================================================================
namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Pasajero;
use App\Models\Proveedor;
use App\Models\Tour;
use App\Models\ToursReserva;
use App\Models\Estadia;
use App\Models\Deposito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Lista de reservas con filtros
     */
    public function index(Request $request)
    {
        $hoy = Carbon::today();

        // Próximas reservas para el sidebar
        $proximasReservas = Reserva::with('titular')
            ->whereDate('fecha_llegada', '>=', $hoy)
            ->orderBy('fecha_llegada', 'asc')
            ->take(5)
            ->get();

        // Query principal con filtros
        $reservas = Reserva::with(['proveedor', 'titular', 'pasajeros', 'toursReservas']);

        // 🔍 Filtro por búsqueda (nombre del titular)
        if ($request->filled('search')) {
            $busqueda = $request->search;
            $reservas->whereHas('titular', function ($q) use ($busqueda) {
                $q->where(DB::raw("CONCAT(nombre,' ',apellido)"), 'LIKE', "%{$busqueda}%");
            });
        }

        // 🔍 Filtro por estado
        if ($request->filled('estado')) {
            $reservas->where('estado', $request->estado);
        }

        // 🔍 Filtro por rango de fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
            $fin = Carbon::parse($request->fecha_fin)->endOfDay();

            $reservas->where(function ($q) use ($inicio, $fin) {
                $q->whereBetween('fecha_llegada', [$inicio, $fin])
                  ->orWhereBetween('fecha_salida', [$inicio, $fin]);
            });
        }

        // 🔍 Filtro de entrantes
        if ($request->get('entrantes') == 1) {
            $reservas->whereDate('fecha_llegada', '>=', $hoy);
        }

        $reservas = $reservas->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.reservas.index', compact('reservas', 'proximasReservas'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $reserva = new Reserva();
        $proveedores = Proveedor::where('estado', 'activo')->get();
        $pasajeros = Pasajero::orderBy('nombre')->get();
        $tours = Tour::orderBy('nombreTour')->get();

        return view('admin.reservas.create', compact('reserva', 'proveedores', 'pasajeros', 'tours'));
    }

    /**
     * Almacenar nueva reserva
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_reserva' => 'required|in:Directo,Recomendacion,Publicidad,Agencia',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'titular_id' => 'required|exists:pasajeros,id',
            'fecha_llegada' => 'nullable|date',
            'hora_llegada' => 'nullable|string',
            'nro_vuelo_llegada' => 'nullable|string',
            'fecha_salida' => 'nullable|date',
            'hora_salida' => 'nullable|string',
            'nro_vuelo_retorno' => 'nullable|string',
            'total' => 'required|numeric|min:0',
            'estado' => 'nullable|in:En espera,Activa,Finalizada,Cancelada',
        ]);

        DB::beginTransaction();
        try {
            // 1️⃣ Crear reserva
            $reserva = Reserva::create($validated);

            // 2️⃣ Asociar pasajeros
            if ($request->filled('pasajeros')) {
                $reserva->pasajeros()->sync($request->pasajeros);
            }

            // 3️⃣ Agregar tours
            if ($request->has('tours') && is_array($request->tours)) {
                $this->procesarTours($reserva, $request->tours);
            }

            // 4️⃣ Agregar estadías
            if ($request->has('estadias') && is_array($request->estadias)) {
                foreach ($request->estadias as $estadiaData) {
                    if (!empty($estadiaData['nombre_estadia'])) {
                        $reserva->estadias()->create($estadiaData);
                    }
                }
            }

            // 5️⃣ Agregar depósitos
            if ($request->has('depositos') && is_array($request->depositos)) {
                foreach ($request->depositos as $depositoData) {
                    if (!empty($depositoData['monto'])) {
                        $reserva->depositos()->create($depositoData);
                    }
                }
            }

            // 6️⃣ Actualizar contadores
            $reserva->actualizarContadores();

            DB::commit();

            return redirect()->route('admin.reservas.index')
                ->with('success', 'Reserva creada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al crear la reserva: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Ver detalles de una reserva
     */
    public function show($id)
    {
        $reserva = Reserva::with([
            'proveedor',
            'titular',
            'pasajeros',
            'toursReservas.tour',
            'toursReservas.detalleMachupicchu',
            'toursReservas.detalleBoletoTuristico',
            'toursReservas.pasajeros',
            'toursReservas.includes',
            'estadias',
            'depositos',
            'facturaciones'
        ])->findOrFail($id);

        return view('admin.reservas.show', compact('reserva'));
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $reserva = Reserva::with([
            'pasajeros',
            'toursReservas.tour',
            'toursReservas.detalleMachupicchu',
            'toursReservas.detalleBoletoTuristico',
            'toursReservas.pasajeros',
            'toursReservas.includes',
            'estadias',
            'depositos'
        ])->findOrFail($id);

        $proveedores = Proveedor::where('estado', 'activo')->get();
        $pasajeros = Pasajero::orderBy('nombre')->get();
        $tours = Tour::orderBy('nombreTour')->get();

        return view('admin.reservas.edit', compact('reserva', 'proveedores', 'pasajeros', 'tours'));
    }

    /**
     * Actualizar reserva existente
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tipo_reserva' => 'required|in:Directo,Recomendacion,Publicidad,Agencia',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'titular_id' => 'required|exists:pasajeros,id',
            'fecha_llegada' => 'nullable|date',
            'hora_llegada' => 'nullable|string',
            'nro_vuelo_llegada' => 'nullable|string',
            'fecha_salida' => 'nullable|date',
            'hora_salida' => 'nullable|string',
            'nro_vuelo_retorno' => 'nullable|string',
            'total' => 'required|numeric|min:0',
            'estado' => 'nullable|in:En espera,Activa,Finalizada,Cancelada',
        ]);

        DB::beginTransaction();
        try {
            $reserva = Reserva::findOrFail($id);
            $reserva->update($validated);

            // 1️⃣ Actualizar pasajeros
            if ($request->filled('pasajeros')) {
                $reserva->pasajeros()->sync($request->pasajeros);
            }

            // 2️⃣ Eliminar datos anteriores que se recrean
            $reserva->estadias()->delete();
            $reserva->depositos()->delete();

            // 3️⃣ Procesar tours (actualizar o crear)
            if ($request->has('tours') && is_array($request->tours)) {
                $this->procesarTours($reserva, $request->tours);
            }

            // 4️⃣ Recrear estadías
            if ($request->has('estadias') && is_array($request->estadias)) {
                foreach ($request->estadias as $estadiaData) {
                    if (!empty($estadiaData['nombre_estadia'])) {
                        $reserva->estadias()->create($estadiaData);
                    }
                }
            }

            // 5️⃣ Recrear depósitos
            if ($request->has('depositos') && is_array($request->depositos)) {
                foreach ($request->depositos as $depositoData) {
                    if (!empty($depositoData['monto'])) {
                        $reserva->depositos()->create($depositoData);
                    }
                }
            }

            // 6️⃣ Actualizar contadores
            $reserva->actualizarContadores();

            DB::commit();

            return redirect()->route('admin.reservas.index')
                ->with('success', 'Reserva actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al actualizar: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Eliminar reserva
     */
    public function destroy($id)
    {
        try {
            $reserva = Reserva::findOrFail($id);
            $reserva->delete();

            return redirect()->route('admin.reservas.index')
                ->with('success', 'Reserva eliminada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors('Error al eliminar: ' . $e->getMessage());
        }
    }

    // =============================================================================
    // 🛠️ MÉTODOS PRIVADOS AUXILIARES
    // =============================================================================

    /**
     * Procesa los tours de una reserva (crear o actualizar)
     */
    private function procesarTours(Reserva $reserva, array $toursData)
    {
        foreach ($toursData as $tourData) {
            if (empty($tourData['tour_id'])) {
                continue;
            }

            // Si tiene ID, actualizar; si no, crear
            $toursReserva = ToursReserva::updateOrCreate(
                ['id' => $tourData['id'] ?? null],
                [
                    'reserva_id' => $reserva->id,
                    'tour_id' => $tourData['tour_id'],
                    'fecha' => $tourData['fecha'] ?? null,
                    'empresa' => $tourData['empresa'] ?? null,
                    'tipo_tour' => $tourData['tipo_tour'] ?? 'Grupal',
                    'idioma' => $tourData['idioma'] ?? null,
                    'lugar_recojo' => $tourData['lugar_recojo'] ?? null,
                    'hora_recojo' => $tourData['hora_recojo'] ?? null,
                    'precio_unitario' => $tourData['precio_unitario'] ?? 0,
                    'cantidad' => $tourData['cantidad'] ?? 1,
                    'observaciones' => $tourData['observaciones'] ?? null,
                    'incluye_entrada' => !empty($tourData['incluye_entrada']),
                    'incluye_tren' => !empty($tourData['incluye_tren']),
                    'estado' => $tourData['estado'] ?? 'Programado',
                ]
            );

            // ✅ Detalles Machupicchu
            if (isset($tourData['detalles_machu'])) {
                $toursReserva->detalleMachupicchu()->updateOrCreate(
                    ['tours_reserva_id' => $toursReserva->id],
                    $this->limpiarNulos($tourData['detalles_machu'])
                );
            }

            // ✅ Detalles Boleto Turístico
            if (isset($tourData['detalles_boleto'])) {
                $toursReserva->detalleBoletoTuristico()->updateOrCreate(
                    ['tours_reserva_id' => $toursReserva->id],
                    $this->limpiarNulos($tourData['detalles_boleto'])
                );
            }

            // ✅ Pasajeros del tour
            $this->procesarPasajerosTour($toursReserva, $tourData);

            // ✅ Includes del tour
            if (isset($tourData['includes']) && is_array($tourData['includes'])) {
                $toursReserva->includes()->delete();
                foreach ($tourData['includes'] as $concepto) {
                    $toursReserva->includes()->create([
                        'concepto' => $concepto,
                        'incluido' => true
                    ]);
                }
            }
        }
    }

    /**
     * Procesa los pasajeros de un tour específico
     */
    private function procesarPasajerosTour(ToursReserva $toursReserva, array $tourData)
    {
        $reserva = $toursReserva->reserva;
        $syncData = [];

        // Modo: todos los pasajeros van
        if (($tourData['modo'] ?? 'todos') === 'todos') {
            foreach ($reserva->pasajeros as $pasajero) {
                $syncData[$pasajero->id] = [
                    'incluido' => true,
                    'comentario' => null
                ];
            }
        } 
        // Modo: personalizado (solo algunos van)
        else {
            $pasajerosSeleccionados = $tourData['pasajeros'] ?? [];
            $comentarios = $tourData['comentarios'] ?? [];

            foreach ($pasajerosSeleccionados as $pasajeroId) {
                $syncData[$pasajeroId] = [
                    'incluido' => true,
                    'comentario' => $comentarios[$pasajeroId] ?? null
                ];
            }
        }

        $toursReserva->pasajeros()->sync($syncData);
    }

    /**
     * Limpia valores nulos de un array para evitar errores de BD
     */
    private function limpiarNulos(array $data): array
    {
        return array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });
    }
}