<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class ToursController extends Controller
{
    public function index()
    {
        $tours = Tour::all();
        return view('admin.tours.index', compact('tours'));
    }

    
    public function create()
    {
        return view('admin.tours.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nombreTour' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Tour::create($request->all());
        return redirect()->route('admin.tours.index')->with('success', 'Tour registrado con éxito.');
    }


    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        $tours = Tour::findOrFail($id);
        return view('admin.tours.edit', compact('tours'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombreTour' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $tours = Tour::findOrFail($id);
        $tours->update($request->all());

        return redirect()->route('admin.tours.index')->with('success', 'Tour actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $tours = Tour::findOrFail($id);
        $tours->delete();

        return redirect()->route('admin.tours.index')->with('success', 'Tour eliminado.');
    }
}
