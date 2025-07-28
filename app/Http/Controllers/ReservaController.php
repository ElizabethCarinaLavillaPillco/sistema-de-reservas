<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Reserva;
use App\Models\Pasajero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with('titular')->orderByDesc('created_at')->get();
        return view('admin.reservas.index', compact('reservas'));
    }

    public function create()
    {
        $pasajeros = Pasajero::all();
        $proveedores = Proveedor::all();

        return view('admin.reservas.create', compact('pasajeros', 'proveedores'));
    }

    public function store(Request $request)
    {
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

        DB::beginTransaction();
        try {
            $last = Reserva::orderBy('created_at', 'desc')->first();
            $num = $last ? (int)substr($last->id, 1) + 1 : 1;
            $id = 'R' . str_pad($num, 4, '0', STR_PAD_LEFT);

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

            if ($request->has('tours')) {
                foreach ($request->tours as $tourData) {
                    DB::table('tours_reserva')->insert([
                        'reserva_id'      => $reserva->id,
                        'nombre_tour'     => $tourData['nombre_tour'] ?? null,
                        'fecha'           => $tourData['fecha'] ?? null,
                        'empresa'         => $tourData['empresa'] ?? null,
                        'precio_unitario' => $tourData['precio_unitario'] ?? 0,
                        'cantidad'        => $tourData['cantidad'] ?? 1,
                        'observaciones'   => $tourData['observaciones'] ?? null,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);
                }
            }

            if ($request->has('pasajeros')) {
                foreach ($request->pasajeros as $pasajero_id) {
                    $pasajero = Pasajero::find($pasajero_id);
                    if ($pasajero) {
                        // Insertar en tabla intermedia
                        $reserva->pasajeros()->attach($pasajero_id);
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

    public function edit($id)
    {
        $reserva = Reserva::with(['pasajeros', 'toursEscritos'])->findOrFail($id);
        $proveedores = Proveedor::all();
        $pasajeros = Pasajero::all();
        return view('admin.reservas.edit', compact('reserva', 'proveedores', 'pasajeros'));
    }

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

        DB::beginTransaction();
        try {
            // Actualizar los datos principales
            $reserva->update([
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

            // Actualizar pasajeros (detach + attach)
            $reserva->pasajeros()->detach();
            if ($request->has('pasajeros')) {
                foreach ($request->pasajeros as $pasajero_id) {
                    $reserva->pasajeros()->attach($pasajero_id);
                }
            }

            // Actualizar tours: eliminar anteriores y agregar nuevos
            DB::table('tours_reserva')->where('reserva_id', $reserva->id)->delete();

            if ($request->has('tours')) {
                foreach ($request->tours as $tourData) {
                    DB::table('tours_reserva')->insert([
                        'reserva_id'      => $reserva->id,
                        'nombre_tour'     => $tourData['nombre_tour'] ?? null,
                        'fecha'           => $tourData['fecha_tour'] ?? null,
                        'empresa'         => $tourData['empresa_tour'] ?? null,
                        'precio_unitario' => $tourData['precio_unitario_tour'] ?? 0,
                        'cantidad'        => $tourData['cantidad_tour'] ?? 1,
                        'observaciones'   => $tourData['observaciones_tour'] ?? null,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.reservas.index')->with('success', 'Reserva actualizada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Error al actualizar la reserva: ' . $e->getMessage())->withInput();
        }
    }


    public function show($id)
    {
        $reserva = Reserva::with(['pasajeros', 'toursEscritos'])->findOrFail($id);
        return view('admin.reservas.show', compact('reserva'));
    }

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }
}
