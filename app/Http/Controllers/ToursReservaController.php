<?php

// =============================================================================
// 🎮 CONTROLADOR: ToursReservaController.php (SIMPLIFICADO)
// =============================================================================
namespace App\Http\Controllers;

use App\Models\ToursReserva;
use Illuminate\Http\Request;

class ToursReservaController extends Controller
{
    /**
     * Eliminar un tour de una reserva
     */
    public function destroy($id)
    {
        try {
            $toursReserva = ToursReserva::findOrFail($id);
            $reservaId = $toursReserva->reserva_id;
            
            $toursReserva->delete();

            return redirect()->route('admin.reservas.edit', $reservaId)
                ->with('success', 'Tour eliminado de la reserva.');
                
        } catch (\Exception $e) {
            return back()->withErrors('Error al eliminar el tour: ' . $e->getMessage());
        }
    }
}