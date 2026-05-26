<?php

namespace App\Http\Controllers\Terapis;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\Terapis;

class DashboardController extends Controller
{
    public function index()
    {
        $terapisUser = Terapis::where('email', auth()->user()->email)->first();

        if (!$terapisUser) {
            return view('terapis.dashboard', [
                'todayBookings' => 0, 'monthBookings' => 0,
                'avgRating' => 0, 'recentBookings' => collect(),
            ]);
        }

        $terapisId = $terapisUser->id;

        $todayBookings = Booking::where('id_terapis', $terapisId)
            ->whereDate('date_booking', today())->count();

        $monthBookings = Booking::where('id_terapis', $terapisId)
            ->whereMonth('date_booking', now()->month)
            ->whereYear('date_booking', now()->year)->count();

        $avgRating = Comment::where('id_terapis', $terapisId)->avg('rating') ?? 0;

        $recentBookings = Booking::with(['customer', 'service.location'])
            ->where('id_terapis', $terapisId)
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        return view('terapis.dashboard', compact(
            'todayBookings', 'monthBookings', 'avgRating', 'recentBookings', 'terapisUser'
        ));
    }
}
