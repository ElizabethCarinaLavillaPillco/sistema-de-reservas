<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Pasajero;
use App\Models\Titular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    // Mostrar lista de reservas
    public function index()
    {
        $reservas = Reserva::with('titular')->get();
        return view('admin.reservas.index', compact('reservas'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $titulares = Titular::all(); // para seleccionar al titular
        return view('admin.reservas.create', compact('titulares'));
    }

    // Guardar nueva reserva
    public function store(Request $request)
    {
        $request->validate([
            'titular_id' => 'required|exists:titulares,id',
            'cantidad_pasajeros' => 'required|integer|min:1',
            'fecha_llegada' => 'required|date',
            'fecha_salida' => 'required|date|after_or_equal:fecha_llegada',
            'cantidad_tours' => 'required|integer|min:0',
            'total' => 'required|numeric|min:0',
            'adelanto' => 'nullable|numeric|min:0',
            // Validaciones opcionales para pasajeros si los envías desde aquí
        ]);

        DB::beginTransaction();
        try {
            // Generar ID personalizado
            $last = Reserva::orderBy('created_at', 'desc')->first();
            $num = $last ? (int)substr($last->id, 1) + 1 : 1;
            $id = 'R' . str_pad($num, 4, '0', STR_PAD_LEFT);


            // Crear la reserva
            $reserva = Reserva::create([
                'id' => $id,
                'titular_id' => $request->titular_id,
                'cantidad_pasajeros' => $request->cantidad_pasajeros,
                'fecha_llegada' => $request->fecha_llegada,
                'fecha_salida' => $request->fecha_salida,
                'cantidad_tours' => $request->cantidad_tours,
                'total' => $request->total,
                'adelanto' => $request->adelanto ?? 0,
            ]);

            // (opcional) Crear pasajeros si los recibes desde el form
            if ($request->has('pasajeros')) {
                foreach ($request->pasajeros as $data) {
                    $reserva->pasajeros()->create($data);
                }
            }

            DB::commit();
            return redirect()->route('admin.reservas.index')->with('success', 'Reserva registrada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al registrar: ' . $e->getMessage());
        }
    }

    // Mostrar formulario para editar
    public function edit($id)
    {
        $reserva = Reserva::with('pasajeros')->findOrFail($id);
        $titulares = Titular::all();
        return view('admin.reservas.edit', compact('reserva', 'titulares'));

    }

    // Actualizar reserva
    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $request->validate([
            'titular_id' => 'required|exists:titulares,id',
            'cantidad_pasajeros' => 'required|integer|min:1',
            'fecha_llegada' => 'required|date',
            'fecha_salida' => 'required|date|after_or_equal:fecha_llegada',
            'cantidad_tours' => 'required|integer|min:0',
            'total' => 'required|numeric|min:0',
            'adelanto' => 'nullable|numeric|min:0',
        ]);

        $reserva->update($request->only([
            'titular_id',
            'cantidad_pasajeros',
            'fecha_llegada',
            'fecha_salida',
            'cantidad_tours',
            'total',
            'adelanto',
        ]));

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    public function show($id)
    {
        $reserva = Reserva::with(['titular', 'pasajeros', 'tours'])->findOrFail($id);
        return view('admin.reservas.show', compact('reserva'));
    }


    // Eliminar reserva
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva eliminada.');
    }
}
