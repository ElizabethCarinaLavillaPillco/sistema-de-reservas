<?php

namespace App\Http\Controllers;

use App\Models\Facturacion;
use App\Models\Pasajero;
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
        $reservas = Reserva::with('titular')->get();
        $pasajeros = Pasajero::select('id','documento','nombre','apellido','pais_residencia')->get();
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
        $reservas = Reserva::with('titular')->get();
        $pasajeros = Pasajero::select('id','documento','nombre','apellido','pais_residencia')->get();
        return view('admin.facturacion.edit', compact('facturacion','reservas','pasajeros'));
    }

    public function update(Request $request, $id)
    {
        $this->validateData($request);
        $facturacion = Facturacion::findOrFail($id);
        $facturacion->update($request->all());
        return redirect()->route('admin.facturacion.index')->with('success', 'Comprobante registrado correctamente.');
    }

    public function show($id)
    {
        $facturacion = Facturacion::with('reserva')->findOrFail($id);
        return view('admin.facturacion.show', compact('facturacion'));
        
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
            'tipo_fac' => 'required|in:Comision,Paquete',
            'reserva_id' => 'nullable|exists:reservas,id',
            'documento' => 'required|string|max:255',
            'titular' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'fecha_giro' => 'required|date',
            'tipo' => 'required|in:Boleta,Factura',
            'total_facturado' => 'required|numeric|min:0',
            'estado' => 'required|in:Sin realizar,Realizado',
            'descripcion' => 'nullable|string',
        ]);
    }
}
