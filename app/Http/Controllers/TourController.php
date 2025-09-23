<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::all();
        return Inertia::render('Tours/Index', ['tours' => $tours]);
    }

    public function show($id)
    {
        $tour = Tour::findOrFail($id);
        $toursRecomendados = Tour::inRandomOrder()->take(8)->get();
        $googleMapsApiKey = env('GOOGLE_MAPS_API_KEY');
        
        return Inertia::render('Tours/Show', [
            'tour' => $tour,
            'toursRecomendados' => $toursRecomendados,
            'googleMapsApiKey' => $googleMapsApiKey,
        ]);
    }
}