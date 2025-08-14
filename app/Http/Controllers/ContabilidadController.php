<?php

namespace App\Http\Controllers;

use App\Models\Contabilidad;
use Illuminate\Http\Request;

class ContabilidadController extends Controller
{
    public function index()
    {
        $contabilidades = Contabilidad::orderBy('fecha_pago', 'desc')->get();
        return view('admin.contabilidad.index', compact('contabilidades'));
    }

    public function create()
    {
        return view('admin.contabilidad.create');
    }

    public function store(Request $request)
    {
        // 1️⃣ Validar primero
        $validated = $request->validate([
            'fecha_pago'   => 'required|date',
            'mes_recibo'   => 'required|string|max:20',
            'anio_recibo'  => 'required|digits:4|integer',
            'essalud'      => 'required|numeric|min:0',
            'afp'          => 'required|numeric|min:0',
            'servicios'    => 'required|numeric|min:0',
            'ir'           => 'nullable|numeric|min:0',
            'renta_anual'  => 'nullable|numeric|min:0',
        ]);

        // 2️⃣ Calcular el total automáticamente
        $validated['total'] =
            ($validated['essalud'] ?? 0) +
            ($validated['afp'] ?? 0) +
            ($validated['servicios'] ?? 0) +
            ($validated['ir'] ?? 0) +
            ($validated['renta_anual'] ?? 0);

        // 3️⃣ Crear el registro una sola vez
        Contabilidad::create($validated);

        return redirect()->route('admin.contabilidad.index')
                        ->with('success', 'Registro agregado con éxito.');
    }

    public function edit(Contabilidad $contabilidad)
    {
        return view('admin.contabilidad.edit', compact('contabilidad'));
    }

    public function update(Request $request, Contabilidad $contabilidad)
    {
        // 1️⃣ Validar
        $validated = $request->validate([
            'fecha_pago'   => 'required|date',
            'mes_recibo'   => 'required|string|max:20',
            'anio_recibo'  => 'required|digits:4|integer',
            'essalud'      => 'required|numeric|min:0',
            'afp'          => 'required|numeric|min:0',
            'servicios'    => 'required|numeric|min:0',
            'ir'           => 'nullable|numeric|min:0',
            'renta_anual'  => 'nullable|numeric|min:0',
        ]);

        // 2️⃣ Calcular total
        $validated['total'] =
            ($validated['essalud'] ?? 0) +
            ($validated['afp'] ?? 0) +
            ($validated['servicios'] ?? 0) +
            ($validated['ir'] ?? 0) +
            ($validated['renta_anual'] ?? 0);

        // 3️⃣ Actualizar el registro
        $contabilidad->update($validated);

        return redirect()->route('admin.contabilidad.index')
                        ->with('success', 'Registro actualizado con éxito.');
    }

    public function destroy(Contabilidad $contabilidad)
    {
        $contabilidad->delete();
        return redirect()->route('admin.contabilidad.index')
                        ->with('success', 'Registro eliminado con éxito.');
    }
}
