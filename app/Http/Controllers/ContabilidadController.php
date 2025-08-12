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
        $data = $request->all();
        $data['total'] = ($request->essalud ?? 0)
                    + ($request->afp ?? 0)
                    + ($request->servicios ?? 0)
                    + ($request->ir ?? 0)
                    + ($request->renta_anual ?? 0);

        Contabilidad::create($data);



        $validated = $request->validate([
            'fecha_pago'   => 'required|date',
            'mes_recibo'   => 'required|string|max:20',
            'anio_recibo'  => 'required|digits:4|integer',
            'essalud'      => 'required|numeric|min:0',
            'afp'          => 'required|numeric|min:0',
            'servicios'    => 'required|numeric|min:0',
            'ir'           => 'nullable|numeric|min:0',
            'renta_anual'  => 'nullable|numeric|min:0',
            'total'        => 'required|numeric|min:0'
        ]);

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

        $data = $request->all();
        $data['total'] = ($request->essalud ?? 0)
                    + ($request->afp ?? 0)
                    + ($request->servicios ?? 0)
                    + ($request->ir ?? 0)
                    + ($request->renta_anual ?? 0);

        Contabilidad::create($data);

        $validated = $request->validate([
            'fecha_pago'   => 'required|date',
            'mes_recibo'   => 'required|string|max:20',
            'anio_recibo'  => 'required|digits:4|integer',
            'essalud'      => 'required|numeric|min:0',
            'afp'          => 'required|numeric|min:0',
            'servicios'    => 'required|numeric|min:0',
            'ir'           => 'nullable|numeric|min:0',
            'renta_anual'  => 'nullable|numeric|min:0',
            'total'        => 'required|numeric|min:0'
        ]);

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
