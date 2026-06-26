<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterSesi;
use App\Models\WaktuLayanan;
use App\Models\Booking;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = MasterSesi::orderBy('jam_mulai')->paginate(10, ['*'], 'sessions_page');
        $holidays = WaktuLayanan::where('active', false)->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'holidays_page');

        return view('admin.sessions.index', compact('sessions', 'holidays'));
    }

    public function create()
    {
        return view('admin.sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi'   => 'nullable|string|max:100',
            'jam_mulai'   => 'required|string|size:5',
            'jam_selesai' => 'required|string|size:5',
            'active'      => 'nullable',
        ]);

        $exists = MasterSesi::where('jam_mulai', $request->jam_mulai)
            ->where('jam_selesai', $request->jam_selesai)
            ->exists();

        if ($exists) {
            return back()->withErrors(['jam_mulai' => 'Kombinasi jam mulai dan jam selesai sudah ada.'])->withInput();
        }

        MasterSesi::create([
            'nama_sesi'   => $request->nama_sesi,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'active'      => $request->has('active'),
        ]);

        return redirect()->route('admin.sessions.index')->with('success', 'Master sesi waktu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $session = MasterSesi::findOrFail($id);
        return view('admin.sessions.edit', compact('session'));
    }

    public function update(Request $request, $id)
    {
        $session = MasterSesi::findOrFail($id);

        $request->validate([
            'nama_sesi'   => 'nullable|string|max:100',
            'jam_mulai'   => 'required|string|size:5',
            'jam_selesai' => 'required|string|size:5',
            'active'      => 'nullable',
        ]);

        $exists = MasterSesi::where('jam_mulai', $request->jam_mulai)
            ->where('jam_selesai', $request->jam_selesai)
            ->where('id', '!=', $session->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['jam_mulai' => 'Kombinasi jam mulai dan jam selesai sudah ada.'])->withInput();
        }

        $session->update([
            'nama_sesi'   => $request->nama_sesi,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'active'      => $request->has('active'),
        ]);

        return redirect()->route('admin.sessions.index')->with('success', 'Master sesi waktu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $session = MasterSesi::findOrFail($id);

        // Check if there are active bookings in the future for this hour slot
        $activeBookingsCount = Booking::where('time_booking', $session->jam_mulai)
            ->where('date_booking', '>=', today()->format('Y-m-d'))
            ->whereNotIn('status_service', ['cancelled', 'completed'])
            ->count();

        if ($activeBookingsCount > 0) {
            return back()->with('error', 'Tidak dapat menghapus sesi ini karena terdapat pemesanan aktif di masa mendatang pada jam tersebut.');
        }

        $session->delete();
        return redirect()->route('admin.sessions.index')->with('success', 'Master sesi waktu berhasil dihapus.');
    }

    /**
     * Store a closed/holiday date exception.
     */
    public function storeHoliday(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        $waktuLayanan = WaktuLayanan::where('tanggal', $request->tanggal)->first();

        if ($waktuLayanan) {
            if (!$waktuLayanan->active) {
                return redirect()->route('admin.sessions.index')->with('info', 'Tanggal tersebut sudah ditandai sebagai hari libur.');
            }
            $waktuLayanan->update(['active' => false]);
        } else {
            WaktuLayanan::create([
                'tanggal'     => $request->tanggal,
                'waktu_buka'  => '08:00',
                'waktu_tutup' => '21:00',
                'maximal'     => 10,
                'active'      => false, // false denotes closed/holiday
            ]);
        }

        return redirect()->route('admin.sessions.index')->with('success', 'Tanggal libur/tutup klinik berhasil ditambahkan.');
    }

    /**
     * Remove a holiday date exception (clinic re-opens on this date).
     */
    public function destroyHoliday($id)
    {
        $holiday = WaktuLayanan::findOrFail($id);
        $holiday->delete();

        return redirect()->route('admin.sessions.index')->with('success', 'Tanggal libur berhasil dihapus (klinik kembali buka pada tanggal tersebut).');
    }
}
