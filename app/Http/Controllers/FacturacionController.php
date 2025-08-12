<?php

namespace App\Http\Controllers;

use App\Models\Facturacion;
use App\Models\Reserva;
use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function index()
    {
        $facturacion = Facturacion::with('reserva')->latest()->paginate(10);
        return view('admin.facturacion.index', compact('facturacion'));
    }

    public function create()
    {
        $reservas = Reserva::orderByDesc('created_at')->get(['id']);
        $pasajeros = Pasajero::select('id','documento','nombre','apellido')->get();
        return view('admin.facturacion.create', compact('reservas','pasajeros'));
    }
    public function store(Request $request)
    {
        $this->validateData($request);
        Facturacion::create($request->all());
        return redirect()->route('admin.facturacion.index')->with('success', 'Comprobante registrado correctamente.');
    }

    public function edit($id)
    {
        $facturacion = Facturacion::findOrFail($id);
        $reservas = Reserva::orderByDesc('created_at')->get(['id']);
        $pasajeros = Pasajero::select('id','documento','nombre','apellido')->get();
        return view('admin.facturacion.edit', compact('facturacion','reservas','pasajeros'));
    }

    public function update(Request $request, $id)
    {
        $this->validateData($request);
        $facturacion = Facturacion::findOrFail($id);
        $facturacion->update($request->all());
        return redirect()->route('admin.facturacion.index')->with('success', 'Comprobante registrado correctamente.');
    }

    public function destroy($id)
    {
        $facturacion = Facturacion::findOrFail($id);
        $facturacion->delete();
        return redirect()->route('admin.facturacion.index')->with('success', 'Comprobante eliminado correctamente.');
    }

    private function validateData(Request $request)
    {
        $request->validate([
            'documento' => 'required|string|max:255',
            'titular' => 'required|string|max:255',
            'reserva_id' => 'required|exists:reservas,id',
            'pais' => 'required|string|max:255',
            'servicio' => 'required|in:Machupicchu,Comision',
            'fecha_giro' => 'required|date',
            'tipo' => 'required|in:Boleta,Factura',
            'total_facturado' => 'required|numeric|min:0',
            'estado' => 'required|in:Sin realizar,Realizado',
            'descripcion' => 'nullable|string',
        ]);
    }
}
