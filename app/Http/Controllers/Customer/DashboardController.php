<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $customerId = auth()->id();

        $totalBooking   = Booking::where('id_customer', $customerId)->count();
        $activeBooking  = Booking::where('id_customer', $customerId)
            ->whereIn('status_service', ['pending', 'confirmed', 'in_progress'])->count();
        $completedBooking = Booking::where('id_customer', $customerId)
            ->where('status_service', 'completed')->count();

        $recentBookings = Booking::with(['terapis', 'service.location'])
            ->where('id_customer', $customerId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('customer.dashboard', compact(
            'totalBooking', 'activeBooking', 'completedBooking', 'recentBookings'
        ));
    }
}
