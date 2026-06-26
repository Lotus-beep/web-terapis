<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\Ruangan;
use App\Models\Bed;
use App\Models\ServiceCategory;
use App\Models\Terapis;
use App\Models\WaktuBoking;
use App\Models\WaktuLayanan;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use \App\Traits\ExportWordReport;

    public function exportWord(Booking $booking)
    {
        if ($booking->id_customer !== auth()->id()) abort(403);
        return $this->generateWordReport($booking);
    }

    public function index(Request $request)
    {
        $query = Booking::with(['terapis', 'service', 'waktuBoking.ruangan'])
            ->where('id_customer', auth()->id());

        if ($request->status_service) {
            $query->where('status_service', $request->status_service);
        }

        if ($request->time_filter) {
            $now = \Carbon\Carbon::now();
            if ($request->time_filter === 'today') {
                $query->whereDate('date_booking', $now->toDateString());
            } elseif ($request->time_filter === 'this_week') {
                $query->whereBetween('date_booking', [
                    $now->copy()->startOfWeek()->toDateString(),
                    $now->copy()->endOfWeek()->toDateString()
                ]);
            } elseif ($request->time_filter === 'this_month') {
                $query->whereMonth('date_booking', $now->month)
                      ->whereYear('date_booking', $now->year);
            }
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Step 1: Tampilkan halaman booking — pilih tanggal, slot, ruangan
     */
    public function create(Request $request)
    {
        $service = ServiceCategory::where('is_active', true)->findOrFail($request->service_id);

        // Tanggal tersedia: waktu_layanan active dari hari ini ke depan
        $availableDates = WaktuLayanan::where('active', true)
            ->where('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->get()
            ->pluck('tanggal')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->toArray();

        return view('customer.bookings.create', compact('service', 'availableDates'));
    }

    /**
     * AJAX: Ambil slot waktu untuk tanggal tertentu
     * GET /customer/bookings/slots?service_id=&date=
     */
    public function getBookedSlots(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:service_categories,id',
            'date'       => 'required|date',
        ]);

        $waktuLayanan = WaktuLayanan::where('tanggal', $request->date)->first();

        if (!$waktuLayanan) {
            $waktuLayanan = WaktuLayanan::create([
                'tanggal'     => $request->date,
                'waktu_buka'  => '08:00',
                'waktu_tutup' => '21:00',
                'maximal'     => 10,
                'active'      => true,
            ]);
        }

        if (!$waktuLayanan->active) {
            return response()->json(['slots' => [], 'message' => 'Klinik libur/tutup pada tanggal ini.']);
        }

        // Generate WaktuBoking slots dynamically based on active rooms and active master sessions
        $activeMasterSessions = \App\Models\MasterSesi::where('active', true)->get();
        $rooms = Ruangan::where('active', true)->get();

        foreach ($activeMasterSessions as $ms) {
            foreach ($rooms as $room) {
                WaktuBoking::firstOrCreate([
                    'id_waktu_layanan' => $waktuLayanan->id,
                    'id_ruangan'        => $room->id,
                    'kode_waktu_boking' => $ms->jam_mulai,
                ], [
                    'active'            => true,
                ]);
            }
        }

        // Ambil gender pasien untuk filter ruangan
        $customer = auth()->user();
        $genderPasien = $request->gender ?: ($request->booking_for === 'other'
            ? $request->gender_second
            : $customer->gender);

        $activeHours = $activeMasterSessions->pluck('jam_mulai')->toArray();

        // Ambil semua slot (waktu_boking) untuk tanggal ini yang terdaftar di Master Sesi aktif
        $slots = WaktuBoking::with(['ruangan'])
            ->where('id_waktu_layanan', $waktuLayanan->id)
            ->where('active', true)
            ->whereIn('kode_waktu_boking', $activeHours)
            ->get()
            ->groupBy('kode_waktu_boking') // group by jam
            ->map(function ($slotGroup, $jam) use ($genderPasien) {
                // Cari data MasterSesi untuk mendapatkan jam_selesai dan nama_sesi
                $ms = \App\Models\MasterSesi::where('jam_mulai', $jam)->first();
                $jamSelesai = $ms ? $ms->jam_selesai : \Carbon\Carbon::parse($jam)->addHour()->format('H:i');
                $namaSesi = $ms ? $ms->nama_sesi : null;

                // Filter ruangan sesuai gender
                $ruanganAvailable = $slotGroup->filter(function ($slot) use ($genderPasien) {
                    $r = $slot->ruangan;
                    if (!$r || !$r->active) return false;
                    if ($r->gender === 'campur') return true;
                    return $r->gender === $genderPasien;
                });

                $totalKursi  = $ruanganAvailable->sum(fn($s) => $s->ruangan->maximal ?? 0);
                $booked      = $ruanganAvailable->sum(fn($s) =>
                    $s->bookings()->whereNotIn('status_service', ['cancelled'])->count()
                );
                $sisa = max(0, $totalKursi - $booked);

                return [
                    'jam'         => $jam,
                    'jam_selesai' => $jamSelesai,
                    'nama_sesi'   => $namaSesi,
                    'total'       => $totalKursi,
                    'booked'      => $booked,
                    'sisa'        => $sisa,
                    'is_full'     => $sisa === 0,
                ];
            })
            ->values();

        return response()->json([
            'date'   => $request->date,
            'slots'  => $slots,
            'buka'   => $waktuLayanan->waktu_buka,
            'tutup'  => $waktuLayanan->waktu_tutup,
        ]);
    }

    /**
     * AJAX: Ambil daftar ruangan untuk jam + tanggal tertentu
     * GET /customer/bookings/ruangan?date=&jam=&gender=
     */
    public function getRuangan(Request $request)
    {
        $request->validate([
            'date'   => 'required|date',
            'jam'    => 'required|string',
            'gender' => 'nullable|string',
        ]);

        $waktuLayanan = WaktuLayanan::where('tanggal', $request->date)
            ->where('active', true)
            ->first();

        if (!$waktuLayanan) {
            return response()->json(['ruangan' => []]);
        }

        $gender = $request->gender ?: auth()->user()->gender;

        $isHourActive = \App\Models\MasterSesi::where('jam_mulai', $request->jam)
            ->where('active', true)
            ->exists();

        if (!$isHourActive) {
            return response()->json(['ruangan' => []]);
        }

        $slots = WaktuBoking::with(['ruangan'])
            ->where('id_waktu_layanan', $waktuLayanan->id)
            ->where('kode_waktu_boking', $request->jam)
            ->where('active', true)
            ->get()
            ->filter(function ($slot) use ($gender) {
                $r = $slot->ruangan;
                if (!$r || !$r->active) return false;
                if ($r->gender === 'campur') return true;
                return $r->gender === $gender;
            })
            ->map(function ($slot) {
                $booked = $slot->bookings()
                    ->whereNotIn('status_service', ['cancelled'])
                    ->count();
                $sisa = max(0, $slot->ruangan->maximal - $booked);

                return [
                    'id_waktu_boking' => $slot->id,
                    'id_ruangan'      => $slot->ruangan->id,
                    'nama_ruangan'    => $slot->ruangan->nama_ruangan,
                    'gender'          => $slot->ruangan->gender,
                    'gender_label'    => $slot->ruangan->gender_label,
                    'maximal'         => $slot->ruangan->maximal,
                    'booked'          => $booked,
                    'sisa'            => $sisa,
                    'is_full'         => $sisa === 0,
                ];
            })
            ->values();

        return response()->json(['ruangan' => $slots]);
    }

    /**
     * AJAX: Ambil daftar bed untuk slot waktu/ruangan tertentu
     * GET /customer/bookings/beds?waktu_boking_id=
     */
    public function getBeds(Request $request)
    {
        $request->validate([
            'waktu_boking_id' => 'required|exists:waktu_boking,id',
        ]);

        $waktuBoking = WaktuBoking::with(['ruangan'])->findOrFail($request->waktu_boking_id);
        $ruangan = $waktuBoking->ruangan;

        if (!$ruangan || !$ruangan->active) {
            return response()->json(['beds' => []]);
        }

        // Ambil semua bed aktif di ruangan ini
        $beds = Bed::where('id_ruangan', $ruangan->id)
            ->where('active', true)
            ->get();

        // Ambil bed yang sudah dibooking pada slot waktu boking ini
        $bookedBedIds = Booking::where('id_waktu_boking', $waktuBoking->id)
            ->whereNotIn('status_service', ['cancelled'])
            ->pluck('id_bed')
            ->toArray();

        $bedList = $beds->map(function ($bed) use ($bookedBedIds) {
            $isBooked = in_array($bed->id, $bookedBedIds);
            return [
                'id'        => $bed->id,
                'nama_bed'  => $bed->nama_bed,
                'is_booked' => $isBooked,
            ];
        });

        return response()->json(['beds' => $bedList]);
    }

    /**
     * Store booking baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_service'       => 'required|exists:service_categories,id',
            'id_waktu_boking'  => 'required|exists:waktu_boking,id',
            'id_ruangan'       => 'required|exists:ruangan,id',
            'id_bed'           => 'required|exists:beds,id',
            'payment_method'   => 'required|in:online,cash',
            'booking_for'      => 'required|in:self,other',
            'second_username'  => 'required_if:booking_for,other|nullable|string|max:100',
            'gender_second'    => 'required_if:booking_for,other|nullable|in:laki-laki,perempuan',
            'keluhan'          => 'required|string',
        ]);

        $service     = ServiceCategory::findOrFail($request->id_service);
        $customer    = auth()->user();
        $waktuBoking = WaktuBoking::with(['waktuLayanan', 'ruangan'])->findOrFail($request->id_waktu_boking);
        $ruangan     = Ruangan::findOrFail($request->id_ruangan);
        $bed         = Bed::findOrFail($request->id_bed);

        // Validasi ruangan milik slot yang dipilih
        if ($waktuBoking->id_ruangan != $ruangan->id) {
            return back()->with('error', 'Ruangan tidak sesuai dengan slot yang dipilih.');
        }

        // Validasi bed milik ruangan yang dipilih
        if ($bed->id_ruangan != $ruangan->id) {
            return back()->with('error', 'Bed tidak berada di ruangan yang dipilih.');
        }

        // Cek apakah bed aktif
        if (!$bed->active) {
            return back()->with('error', 'Bed yang Anda pilih sedang tidak aktif.');
        }

        // Cek apakah bed sudah dipesan untuk slot ini
        $bedBooked = Booking::where('id_waktu_boking', $waktuBoking->id)
            ->where('id_bed', $bed->id)
            ->whereNotIn('status_service', ['cancelled'])
            ->exists();

        if ($bedBooked) {
            return back()->with('error', 'Bed ' . $bed->nama_bed . ' sudah terisi oleh pasien lain.');
        }

        // Cek kapasitas ruangan untuk slot ini
        $booked = Booking::where('id_waktu_boking', $waktuBoking->id)
            ->where('id_ruangan', $ruangan->id)
            ->whereNotIn('status_service', ['cancelled'])
            ->count();

        if ($booked >= $ruangan->maximal) {
            return back()->with('error', 'Maaf, ruangan ' . $ruangan->nama_ruangan . ' sudah penuh untuk slot ini.');
        }

        // Validasi gender ruangan
        $genderPasien = $request->booking_for === 'other'
            ? $request->gender_second
            : $customer->gender;

        if ($ruangan->gender !== 'campur' && $ruangan->gender !== $genderPasien) {
            return back()->with('error', 'Ruangan ini tidak sesuai dengan jenis kelamin pasien.');
        }

        $tanggal    = $waktuBoking->waktuLayanan->tanggal->format('Y-m-d');
        $jamBooking = $waktuBoking->kode_waktu_boking;

        $booking = Booking::create([
            'id_customer'     => $customer->id,
            'id_terapis'      => null,
            'id_service'      => $service->id,
            'id_waktu_boking' => $waktuBoking->id,
            'id_ruangan'      => $ruangan->id,
            'id_bed'          => $bed->id,
            'date_booking'    => $tanggal,
            'time_booking'    => $jamBooking,
            'payment_method'  => $request->payment_method,
            'status_payment'  => 'unpaid',
            'status_service'  => 'pending',
            'booking_for'     => $request->booking_for,
            'second_username' => $request->booking_for === 'other' ? $request->second_username : null,
            'gender_second'   => $request->booking_for === 'other' ? $request->gender_second : null,
            'keluhan'         => $request->keluhan,
        ]);

        if ($request->payment_method === 'online') {
            try {
                $midtrans  = new MidtransService();
                $snapToken = $midtrans->createSnapToken($booking);

                return redirect()->route('customer.bookings.show', $booking->id)
                    ->with('snap_token', $snapToken)
                    ->with('snap_url', config('midtrans.snap_url'));
            } catch (\RuntimeException $e) {
                $booking->update(['payment_method' => 'cash']);
                return redirect()->route('customer.bookings.show', $booking->id)
                    ->with('error', 'Pembayaran online belum tersedia. (' . $e->getMessage() . ')');
            } catch (\Exception $e) {
                $booking->delete();
                return back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
            }
        }

        return redirect()->route('customer.bookings.show', $booking->id)
            ->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');
    }

    public function show(Booking $booking)
    {
        if ($booking->id_customer !== auth()->id()) {
            abort(403);
        }

        $booking->load(['terapis', 'service', 'waktuBoking.ruangan', 'location', 'therapyReport']);
        $hasComment = Comment::where('id_booking', $booking->id)->exists();

        $snapToken = session('snap_token');
        $clientKey = session('client_key', config('midtrans.client_key'));
        $snapUrl   = session('snap_url', config('midtrans.snap_url'));

        return view('customer.bookings.show', compact('booking', 'hasComment', 'snapToken', 'clientKey', 'snapUrl'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->id_customer !== auth()->id()) {
            abort(403);
        }
        if ($booking->status_service !== 'pending') {
            return back()->with('error', 'Booking tidak bisa dibatalkan.');
        }
        $booking->update(['status_service' => 'cancelled']);
        return back()->with('success', 'Booking berhasil dibatalkan.');
    }

    public function uploadPayment(Request $request, Booking $booking)
    {
        if ($booking->id_customer !== auth()->id()) {
            abort(403);
        }
        $request->validate(['payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048']);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $booking->update([
            'payment_proof'  => $path,
            'status_payment' => 'waiting_confirmation',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }

    public function midtransCallback(Request $request)
    {
        try {
            $midtrans = new MidtransService();
            $midtrans->handleNotification();
        } catch (\Exception $e) {
            \Log::error('Midtrans webhook error: ' . $e->getMessage());
        }
        return response()->json(['status' => 'ok']);
    }

    public function paymentFinish(Request $request)
    {
        $orderId = $request->query('order_id');
        if (!$orderId) {
            return redirect()->route('customer.bookings.index')->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $booking = Booking::where('midtrans_order_id', $orderId)
            ->when(auth()->check(), fn($q) => $q->where('id_customer', auth()->id()))
            ->first() ?? Booking::where('midtrans_order_id', $orderId)->first();

        if (!$booking) {
            return redirect()->route('login')->with('error', 'Booking tidak ditemukan.');
        }

        if (in_array($booking->status_payment, ['pending_snap', 'unpaid'])) {
            try {
                $midtrans = new MidtransService();
                $status   = $midtrans->checkTransactionStatus($orderId);
                if ($status) {
                    $midtrans->processStatus($booking, $status['transaction_status'] ?? '', $status['fraud_status'] ?? '');
                    $booking->refresh();
                }
            } catch (\Exception $e) {
                \Log::error('paymentFinish check error: ' . $e->getMessage());
            }
        }

        $message = match($booking->status_payment) {
            'paid'          => 'Pembayaran berhasil! Booking dikonfirmasi.',
            'pending_snap',
            'unpaid'        => 'Pembayaran sedang diproses.',
            'expired'       => 'Sesi pembayaran telah kadaluarsa.',
            'rejected'      => 'Pembayaran ditolak atau gagal.',
            default         => 'Status pembayaran diperbarui.',
        };

        $type = $booking->status_payment === 'paid' ? 'success' : 'error';
        return redirect()->route('customer.bookings.show', $booking->id)->with($type, $message);
    }

    public function paymentError(Request $request)
    {
        $orderId = $request->query('order_id');
        $booking = $orderId ? Booking::where('midtrans_order_id', $orderId)->first() : null;

        if ($booking && in_array($booking->status_payment, ['pending_snap', 'unpaid'])) {
            $booking->update(['status_payment' => 'rejected', 'status_service' => 'cancelled']);
            return redirect()->route('customer.bookings.show', $booking->id)
                ->with('error', 'Pembayaran gagal atau dibatalkan.');
        }

        return redirect()->route('customer.bookings.index')->with('error', 'Pembayaran gagal.');
    }

    public function storeComment(Request $request, Booking $booking)
    {
        if ($booking->id_customer !== auth()->id()) abort(403);
        if ($booking->status_service !== 'completed') {
            return back()->with('error', 'Komentar hanya bisa untuk booking yang sudah selesai.');
        }

        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $existing = Comment::where('id_booking', $booking->id)->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        Comment::create([
            'id_customer' => auth()->id(),
            'id_terapis'  => $booking->id_terapis,
            'id_booking'  => $booking->id,
            'rating'      => 0, // Default since rating feature is removed
            'comment'     => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
