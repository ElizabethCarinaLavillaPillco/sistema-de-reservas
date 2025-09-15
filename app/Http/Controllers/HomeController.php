<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Tour;

class HomeController extends Controller
{
    public function index()
    {
        $tours = Tour::where('featured', true)
                    ->with('images')
                    ->limit(6)
                    ->get();
                    
        return Inertia::render('Home/Index', [
            'tours' => $tours
        ]);
    }
}