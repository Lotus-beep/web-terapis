<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Terapis;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'terapis', 'service']);
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
        $booking->load(['customer', 'terapis', 'location', 'service']);
        $terapisList  = Terapis::orderBy('username')->get();
        $locationList = Location::orderBy('name_location')->get();
        return view('admin.bookings.show', compact('booking', 'terapisList', 'locationList'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate(['status_service' => 'required|in:pending,confirmed,in_progress,completed,cancelled']);
        $booking->update(['status_service' => $request->status_service]);
        return back()->with('success', 'Status booking berhasil diupdate.');
    }

    /**
     * Admin assign terapis + lokasi ke booking
     */
    public function assignTerapis(Request $request, Booking $booking)
    {
        $request->validate([
            'id_terapis'  => 'required|exists:terapis,id',
            'id_location' => 'nullable|exists:location,id',
        ]);

        $booking->update([
            'id_terapis'     => $request->id_terapis,
            'id_location'    => $request->id_location ?: null,
            'status_service' => 'confirmed',
        ]);

        return back()->with('success', 'Terapis berhasil ditugaskan dan booking dikonfirmasi.');
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
