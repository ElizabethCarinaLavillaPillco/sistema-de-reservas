<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedoresController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('admin.proveedores.index', compact('proveedores'));
    }

    
    public function create()
    {
        return view('admin.proveedores.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nombreAgencia' => 'required|string|max:255',
            'nombreEncargado' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
        ]);

        Proveedor::create($request->all());
        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor registrado con éxito.');
    }


    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        $proveedores = Proveedor::findOrFail($id);
        return view('admin.proveedores.edit', compact('proveedores'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombreAgencia' => 'required|string|max:255',
            'nombreEncargado' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
        ]);

        $proveedores = Proveedor::findOrFail($id);
        $proveedores->update($request->all());

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $proveedores = Proveedor::findOrFail($id);
        $proveedores->delete();

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor eliminado.');
    }
}
