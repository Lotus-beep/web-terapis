<?php

namespace App\Http\Controllers\Terapis;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Terapis;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private function getTerapisId(): ?int
    {
        $t = Terapis::where('email', auth()->user()->email)->first();
        return $t ? $t->id : null;
    }

    public function index(Request $request)
    {
        $terapisId = $this->getTerapisId();
        $query = Booking::with(['customer', 'service.location'])
            ->where('id_terapis', $terapisId);

        if ($request->status_service) {
            $query->where('status_service', $request->status_service);
        }
        if ($request->date) {
            $query->whereDate('date_booking', $request->date);
        }

        $bookings = $query->orderBy('date_booking', 'asc')->paginate(10);
        return view('terapis.bookings.index', compact('bookings'));
    }

    public function confirm(Booking $booking)
    {
        if ($booking->id_terapis !== $this->getTerapisId()) abort(403);
        if ($booking->status_service !== 'pending') {
            return back()->with('error', 'Booking tidak bisa dikonfirmasi.');
        }
        $booking->update(['status_service' => 'confirmed']);
        return back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        if ($booking->id_terapis !== $this->getTerapisId()) abort(403);
        $request->validate(['status_service' => 'required|in:in_progress,completed']);
        $booking->update(['status_service' => $request->status_service]);
        return back()->with('success', 'Status berhasil diupdate.');
    }

    public function schedule(Request $request)
    {
        $terapisId = $this->getTerapisId();
        $query = Booking::with(['customer', 'service.location'])
            ->where('id_terapis', $terapisId)
            ->whereIn('status_service', ['confirmed', 'in_progress']);

        if ($request->date) {
            $query->whereDate('date_booking', $request->date);
        } else {
            $query->whereDate('date_booking', '>=', today());
        }

        $bookings = $query->orderBy('date_booking', 'asc')->orderBy('time_booking', 'asc')->get();
        return view('terapis.bookings.schedule', compact('bookings'));
    }
}
