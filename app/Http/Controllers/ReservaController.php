<?php

namespace App\Http\Controllers;
use App\Models\Proveedor;
use App\Models\Tour;
use App\Models\Reserva;
use App\Models\Pasajero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    // Mostrar lista de reservas
    public function index()
    {
        $reservas = Reserva::with('titular')->orderByDesc('created_at')->get();
        return view('admin.reservas.index', compact('reservas'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $pasajeros = Pasajero::all();
        $proveedores = Proveedor::all();
        $tours = Tour::all();

        return view('admin.reservas.create', compact('pasajeros', 'proveedores', 'tours'));
    }

    // Guardar nueva reserva
    public function store(Request $request)
    {
        $request->validate([
            'pasajero_id' => 'required|exists:pasajeros,id',
            'tipo_reserva' => 'required|in:Directo,Recomendacion,Publicidad,Agencia',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'cantidad_pasajeros' => 'required|integer|min:1',
            'fecha_llegada' => 'required|date',
            'fecha_salida' => 'required|date|after_or_equal:fecha_llegada',
            'cantidad_tours' => 'required|integer|min:0',
            'total' => 'required|numeric|min:0',
            'adelanto' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generar ID personalizado
            $last = Reserva::orderBy('created_at', 'desc')->first();
            $num = $last ? (int)substr($last->id, 1) + 1 : 1;
            $id = 'R' . str_pad($num, 4, '0', STR_PAD_LEFT);

            // Crear reserva
            $reserva = Reserva::create([
                'id' => $id,
                'titular_id' => $request->titular_id,
                'tipo_reserva' => $request->tipo_reserva,
                'proveedor_id' => $request->proveedor_id,
                'cantidad_pasajeros' => $request->cantidad_pasajeros,
                'fecha_llegada' => $request->fecha_llegada,
                'fecha_salida' => $request->fecha_salida,
                'cantidad_tours' => $request->cantidad_tours,
                'total' => $request->total,
                'adelanto' => $request->adelanto ?? 0,
            ]);

            // Guardar tours asociados (tour_reservas)
            if ($request->has('tours')) {
                foreach ($request->tours as $tourData) {
                    $reserva->tourReservas()->create([
                        'tour_id' => $tourData['tour_id'],
                        'fecha' => $tourData['fecha'] ?? null,
                        'empresa' => $tourData['empresa'] ?? null,
                        'precio_unitario' => $tourData['precio_unitario'] ?? 0,
                        'cantidad' => $tourData['cantidad'] ?? 1,
                        'observaciones' => $tourData['observaciones'] ?? null,
                    ]);
                }
            }


            // Guardar pasajeros (si vienen del formulario)
            if ($request->has('pasajeros')) {
                foreach ($request->pasajeros as $pasajero_id) {
                    $pasajero = Pasajero::find($pasajero_id);
                    if ($pasajero) {
                        $pasajero->reserva_id = $reserva->id;
                        $pasajero->save();
                    }
                }
            }


            DB::commit();
            return redirect()->route('admin.reservas.index')->with('success', 'Reserva registrada con éxito.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Error al registrar la reserva: ' . $e->getMessage())->withInput();
        }
    }

    // Mostrar formulario para editar
    public function edit($id)
    {
        $reserva = Reserva::with('pasajeros')->findOrFail($id);
        $proveedores = Proveedor::all();
        $tours = Tour::all();   
        $pasajeros = Pasajero::all();
        return view('admin.reservas.edit', compact('reserva', 'proveedores', 'tours', 'pasajeros'));
    }

    // Actualizar una reserva existente
    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $request->validate([
            'titular_id' => 'required|exists:pasajeros,id',
            'tipo_reserva' => 'required|in:Directo,Recomendacion,Publicidad,Agencia',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'cantidad_pasajeros' => 'required|integer|min:1',
            'fecha_llegada' => 'required|date',
            'fecha_salida' => 'required|date|after_or_equal:fecha_llegada',
            'cantidad_tours' => 'required|integer|min:0',
            'total' => 'required|numeric|min:0',
            'adelanto' => 'nullable|numeric|min:0',
        ]);

        $reserva->update($request->only([
            'titular_id',
            'tipo_reserva',
            'proveedor_id',
            'cantidad_pasajeros',
            'fecha_llegada',
            'fecha_salida',
            'cantidad_tours',
            'total',
            'adelanto',
        ]));

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    // Mostrar detalles
    public function show($id)
    {
        $reserva = Reserva::with(['pasajeros', 'tourReservas.tour'])->findOrFail($id);
        return view('admin.reservas.show', compact('reserva'));
    }

    // Eliminar reserva
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }
}
