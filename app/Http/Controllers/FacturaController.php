<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Mostrar todas las facturas.
     */
    public function index()
    {
        $facturas = Factura::latest()->paginate(10);
        return view('admin.facturas.index', compact('facturas'));
    }

    /**
     * Mostrar formulario para crear una nueva factura.
     */
    public function create()
    {
        return view('admin.facturas.create');
    }

    /**
     * Guardar una nueva factura en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titular' => 'required|string|max:255',
            'ruc' => 'required|string|max:20',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        Factura::create($request->all());

        return redirect()->route('admin.facturas.index')->with('success', 'Factura registrada con éxito.');
    }

    /**
     * Mostrar el formulario para editar una factura.
     */
    public function edit(Factura $factura)
    {
        return view('admin.facturas.edit', compact('factura'));
    }

    /**
     * Actualizar una factura en la base de datos.
     */
    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'titular' => 'required|string|max:255',
            'ruc' => 'required|string|max:20',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $factura->update($request->all());

        return redirect()->route('admin.facturas.index')->with('success', 'Factura actualizada con éxito.');
    }

    /**
     * Eliminar una factura.
     */
    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('admin.facturas.index')->with('success', 'Factura eliminada con éxito.');
    }
}
