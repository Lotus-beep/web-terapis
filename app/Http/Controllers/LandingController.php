<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Terapis;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil 6 service terbaru dengan kategori
        $services = Service::with(['terapis', 'location', 'category'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Ambil terapis dengan rating tertinggi
        $terapis = Terapis::orderBy('rating', 'desc')
            ->take(3)
            ->get();

        return view('landing.index', compact('services', 'terapis'));
    }
}
