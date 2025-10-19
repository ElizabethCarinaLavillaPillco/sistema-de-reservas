<?php

// =============================================================================
// 🎮 CONTROLADOR: DepositosController.php (SIMPLIFICADO)
// =============================================================================
namespace App\Http\Controllers;

use App\Models\Deposito;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositosController extends Controller
{
    public function index()
    {
        $depositos = Deposito::with('reserva.titular')
            ->orderBy('fecha', 'desc')
            ->paginate(20);
            
        return view('admin.depositos.index', compact('depositos'));
    }

    public function create()
    {
        $reservas = Reserva::with('titular')->get();
        $tipos = Deposito::TIPOS;
        
        return view('admin.depositos.create', compact('reservas', 'tipos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_depositante' => 'required|string|max:255',
            'reserva_id' => 'required|exists:reservas,id',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'tipo_deposito' => 'required|in:' . implode(',', Deposito::TIPOS),
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $deposito = Deposito::create($validated);
            
            // Actualizar adelanto de la reserva
            $deposito->reserva->actualizarContadores();

            DB::commit();
            
            return redirect()->route('admin.depositos.index')
                ->with('success', 'Depósito registrado correctamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $deposito = Deposito::findOrFail($id);
        $reservas = Reserva::with('titular')->get();
        $tipos = Deposito::TIPOS;
        
        return view('admin.depositos.edit', compact('deposito', 'reservas', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        $deposito = Deposito::findOrFail($id);

        $validated = $request->validate([
            'nombre_depositante' => 'required|string|max:255',
            'reserva_id' => 'required|exists:reservas,id',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'tipo_deposito' => 'required|in:' . implode(',', Deposito::TIPOS),
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $deposito->update($validated);
            
            // Actualizar adelanto
            $deposito->reserva->actualizarContadores();

            DB::commit();
            
            return redirect()->route('admin.depositos.index')
                ->with('success', 'Depósito actualizado correctamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $deposito = Deposito::findOrFail($id);
            $reserva = $deposito->reserva;
            
            $deposito->delete();
            
            // Actualizar adelanto
            $reserva->actualizarContadores();

            return redirect()->route('admin.depositos.index')
                ->with('success', 'Depósito eliminado correctamente.');
                
        } catch (\Exception $e) {
            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }
}
