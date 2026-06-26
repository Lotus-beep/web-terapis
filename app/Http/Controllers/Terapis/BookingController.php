<?php

namespace App\Http\Controllers\Terapis;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Terapis;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use \App\Traits\ExportWordReport;

    public function exportWord(Booking $booking)
    {
        if ($booking->id_terapis !== $this->getTerapisId()) abort(403);
        return $this->generateWordReport($booking);
    }

    private function getTerapisId(): ?int
    {
        $t = Terapis::where('email', auth()->user()->email)->first();
        return $t ? $t->id : null;
    }

    public function index(Request $request)
    {
        $terapisId = $this->getTerapisId();
        $query = Booking::with(['customer', 'service', 'ruangan', 'bed', 'therapyReport'])
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

    public function report(Booking $booking)
    {
        if ($booking->id_terapis !== $this->getTerapisId()) abort(403);
        $booking->load('therapyReport');
        return view('terapis.bookings.report', compact('booking'));
    }

    public function storeReport(Request $request, Booking $booking)
    {
        if ($booking->id_terapis !== $this->getTerapisId()) abort(403);
        
        $data = $request->validate([
            'keluhan_sebelum' => 'nullable|string',
            'tindakan_terapi' => 'nullable|string',
            'tekanan_darah' => 'nullable|string',
            'suhu_tubuh' => 'nullable|string',
            'kondisi_umum' => 'nullable|string',
            'area_keluhan' => 'nullable|string',
            'hasil_setelah_terapi' => 'nullable|string',
            'catatan_terapis' => 'nullable|string',
            'saran_terapis' => 'nullable|string',
        ]);

        $data['tindakan_terapi'] = json_encode($data['tindakan_terapi'] ?? '');
        $data['hasil_setelah_terapi'] = json_encode($data['hasil_setelah_terapi'] ?? '');

        if ($booking->therapyReport) {
            $booking->therapyReport->update($data);
        } else {
            $booking->therapyReport()->create($data);
        }

        return redirect()->route('terapis.bookings.index')->with('success', 'Laporan terapi berhasil disimpan.');
    }

    public function schedule(Request $request)
    {
        $terapisId = $this->getTerapisId();
        $query = Booking::with(['customer', 'service', 'ruangan', 'bed', 'location'])
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
