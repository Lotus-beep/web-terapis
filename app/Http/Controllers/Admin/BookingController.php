<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'terapis', 'service.location']);
        if ($request->status_service) {
            $query->where('status_service', $request->status_service);
        }
        if ($request->status_payment) {
            $query->where('status_payment', $request->status_payment);
        }
        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer', 'terapis', 'service.location']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate(['status_service' => 'required|in:pending,confirmed,in_progress,completed,cancelled']);
        $booking->update(['status_service' => $request->status_service]);
        return back()->with('success', 'Status booking berhasil diupdate.');
    }

    public function confirmPayment(Request $request, Booking $booking)
    {
        $booking->update(['status_payment' => 'paid']);
        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function rejectPayment(Request $request, Booking $booking)
    {
        $booking->update(['status_payment' => 'rejected']);
        return back()->with('success', 'Pembayaran ditolak.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}
