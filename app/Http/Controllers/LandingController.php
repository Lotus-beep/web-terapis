<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Terapis;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil 6 service categories aktif
        $services = ServiceCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        // Ambil terapis dengan rating tertinggi
        $terapis = Terapis::orderBy('rating', 'desc')
            ->take(3)
            ->get();

        return view('landing.index', compact('services', 'terapis'));
    }
}
