<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Terapis;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomer = User::where('role_users', 'customer')->count();
        $totalTerapis  = Terapis::count();
        $totalBooking  = Booking::count();
        $totalPendapatan = Booking::where('booking.status_payment', 'paid')
            ->join('service_categories', 'booking.id_service', '=', 'service_categories.id')
            ->sum('service_categories.price');

        $recentBookings = Booking::with(['customer', 'terapis', 'service'])
            ->orderBy('booking.created_at', 'desc')
            ->take(5)
            ->get();

        $pendingPayments = Booking::with(['customer', 'terapis', 'service'])
            ->where('booking.status_payment', 'waiting_confirmation')
            ->orderBy('booking.created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalCustomer', 'totalTerapis', 'totalBooking',
            'totalPendapatan', 'recentBookings', 'pendingPayments'
        ));
    }
}
