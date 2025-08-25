<?php

namespace App\Http\Controllers;

use App\Models\Deposito;
use App\Models\Reserva;
use App\Models\Pasajero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DepositosController extends Controller
{
    public function index()
    {
        $depositos = Deposito::orderBy('created_at', 'desc')->paginate(10); // <--- paginar
        return view('admin.depositos.index', compact('depositos'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        // Para autocompletar, traemos id + titular
        $reservas = Reserva::with('titular')->get();
        $tipos    = Deposito::TIPOS;

        return view('admin.depositos.create', compact('reservas', 'tipos'));
    }


    /**
     * Almacenar nuevo depósito.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_depositante' => 'required|string|max:255',
            'reserva_id' => 'required|string|exists:reservas,id',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'tipo_deposito' => 'required|in:' . implode(',', Deposito::TIPOS),
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            Deposito::create($request->only([
                'nombre_depositante',
                'reserva_id',
                'monto',
                'fecha',
                'tipo_deposito',
                'observaciones',
            ]));

            DB::commit();
            return redirect()->route('admin.depositos.index')->with('success', 'Depósito registrado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Error al guardar el depósito: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $depositos = Deposito::findOrFail($id);
        $reservas = Reserva::with('titular')->get();
        $tipos = Deposito::TIPOS;
        return view('admin.depositos.edit', compact('depositos', 'reservas', 'tipos'));

    }

    
    public function update(Request $request, $id)
    {
        $depositos = Deposito::findOrFail($id);

        $request->validate([
            'nombre_depositante' => 'required|string|max:255',
            'reserva_id' => 'required|string|exists:reservas,id',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'tipo_deposito' => 'required|in:' . implode(',', Deposito::TIPOS),
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $depositos->update($request->only([
                'nombre_depositante',
                'reserva_id',
                'monto',
                'fecha',
                'tipo_deposito',
                'observaciones',
            ]));

            DB::commit();
            return redirect()->route('admin.depositos.index')->with('success', 'Depósito actualizado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Error al actualizar el depósito: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $depositos = Deposito::with('reserva')->findOrFail($id);
        return view('admin.depositos.show', compact('depositos'));
        
    }

    public function destroy($id)
    {
        $depositos = Deposito::findOrFail($id);
        $depositos->delete();

        return redirect()->route('admin.depositos.index')->with('success', 'Depósito eliminado correctamente.');
    }
}
