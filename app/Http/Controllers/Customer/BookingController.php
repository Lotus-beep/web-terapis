<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\Service;
use App\Models\Terapis;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['terapis', 'service'])
            ->where('id_customer', auth()->id());

        if ($request->status_service) {
            $query->where('status_service', $request->status_service);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Step 1: Choose date & time for a given service
     */
    public function create(Request $request)
    {
        $service = Service::with('terapis')->findOrFail($request->service_id);

        // Gender matching: only show service if terapis gender matches customer gender
        $customer = auth()->user();
        if ($customer->gender && $service->terapis->gender && $customer->gender !== $service->terapis->gender) {
            return redirect()->route('customer.services.index')
                ->with('error', 'Layanan ini hanya tersedia untuk gender ' . $service->terapis->gender . '.');
        }

        return view('customer.bookings.create', compact('service'));
    }

    /**
     * AJAX: Get booked slots for a service on a date
     */
    public function getBookedSlots(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:service,id',
            'date'       => 'required|date',
        ]);

        $bookedSlots = Booking::where('id_service', $request->service_id)
            ->where('date_booking', $request->date)
            ->whereNotIn('status_service', ['cancelled'])
            ->pluck('time_booking')
            ->toArray();

        return response()->json(['booked_slots' => $bookedSlots]);
    }

    /**
     * Step 2: Show payment method selection
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_service'      => 'required|exists:service,id',
            'date_booking'    => 'required|date|after_or_equal:today',
            'time_booking'    => 'required',
            'payment_method'  => 'required|in:online,cash',
        ]);

        $service  = Service::with('terapis')->findOrFail($request->id_service);
        $customer = auth()->user();

        // Gender check
        if ($customer->gender && $service->terapis->gender && $customer->gender !== $service->terapis->gender) {
            return back()->with('error', 'Tidak bisa booking layanan ini karena tidak sesuai gender.');
        }

        // Slot lock check
        if ($service->isSlotTaken($request->date_booking, $request->time_booking)) {
            return back()->with('error', 'Maaf, jadwal ' . $request->time_booking . ' pada tanggal ' . $request->date_booking . ' sudah dipesan. Silakan pilih waktu lain.');
        }

        $booking = Booking::create([
            'id_customer'    => $customer->id,
            'id_terapis'     => $service->id_terapis,
            'id_service'     => $service->id,
            'date_booking'   => $request->date_booking,
            'time_booking'   => $request->time_booking,
            'payment_method' => $request->payment_method,
            'status_payment' => 'unpaid',
            'status_service' => 'pending',
        ]);

        // If online payment → create snap token
        if ($request->payment_method === 'online') {
            try {
                $midtrans  = new MidtransService();
                $snapToken = $midtrans->createSnapToken($booking);

                return redirect()->route('customer.bookings.show', $booking->id)
                    ->with('snap_token', $snapToken)
                    ->with('snap_url', config('midtrans.snap_url'));
            } catch (\RuntimeException $e) {
                // Midtrans SDK belum terinstall
                $booking->update(['payment_method' => 'cash']);
                return redirect()->route('customer.bookings.show', $booking->id)
                    ->with('error', 'Pembayaran online belum tersedia. Silakan gunakan metode Cash. (' . $e->getMessage() . ')');
            } catch (\Exception $e) {
                $booking->delete();
                return back()->with('error', 'Gagal membuat transaksi pembayaran: ' . $e->getMessage());
            }
        }

        // Cash: go to booking detail with upload instruction
        return redirect()->route('customer.bookings.show', $booking->id)
            ->with('success', 'Booking berhasil! Silakan lakukan pembayaran cash saat sesi berlangsung.');
    }

    public function show(Booking $booking)
    {
        if ($booking->id_customer !== auth()->id()) {
            abort(403);
        }

        $booking->load(['terapis', 'service']);
        $hasComment = Comment::where('id_customer', auth()->id())
            ->where('id_terapis', $booking->id_terapis)->exists();

        // Re-fetch snap token from session if redirected from store
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

    /**
     * Upload bukti pembayaran cash
     */
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

    /**
     * Midtrans webhook callback (dipanggil server Midtrans via POST)
     */
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

    /**
     * Finish redirect — Midtrans redirect ke /payment/finish setelah user bayar
     * Midtrans kirim query string: order_id, status_code, transaction_status
     */
    public function paymentFinish(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect()->route('customer.bookings.index')
                ->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $booking = Booking::where('midtrans_order_id', $orderId)
            ->when(auth()->check(), fn($q) => $q->where('id_customer', auth()->id()))
            ->first();

        if (!$booking) {
            $booking = Booking::where('midtrans_order_id', $orderId)->first();
            if (!$booking) {
                return redirect()->route('login')
                    ->with('error', 'Booking tidak ditemukan. Silakan login untuk melihat status pembayaran.');
            }
        }

        // Cek status terbaru ke Midtrans API jika masih pending
        if (in_array($booking->status_payment, ['pending_snap', 'unpaid'])) {
            try {
                $midtrans = new MidtransService();
                $status   = $midtrans->checkTransactionStatus($orderId);

                if ($status) {
                    $midtrans->processStatus(
                        $booking,
                        $status['transaction_status'] ?? '',
                        $status['fraud_status']       ?? ''
                    );
                    $booking->refresh();
                }
            } catch (\Exception $e) {
                \Log::error('paymentFinish check error: ' . $e->getMessage());
            }
        }

        $message = match($booking->status_payment) {
            'paid'         => 'Pembayaran berhasil! Booking Anda telah dikonfirmasi.',
            'pending_snap',
            'unpaid'       => 'Pembayaran sedang diproses. Halaman akan diperbarui otomatis.',
            'expired'      => 'Sesi pembayaran telah kadaluarsa.',
            'rejected'     => 'Pembayaran ditolak atau gagal.',
            default        => 'Status pembayaran diperbarui.',
        };

        $type = $booking->status_payment === 'paid' ? 'success' : 'error';

        return redirect()->route('customer.bookings.show', $booking->id)
            ->with($type, $message);
    }

    /**
     * Error redirect — Midtrans redirect ke /payment/error saat gagal
     */
    public function paymentError(Request $request)
    {
        $orderId = $request->query('order_id');

        $booking = $orderId
            ? Booking::where('midtrans_order_id', $orderId)->first()
            : null;

        if ($booking) {
            // Update status ke rejected jika belum
            if (in_array($booking->status_payment, ['pending_snap', 'unpaid'])) {
                $booking->update([
                    'status_payment' => 'rejected',
                    'status_service' => 'cancelled',
                ]);
            }

            return redirect()->route('customer.bookings.show', $booking->id)
                ->with('error', 'Pembayaran gagal atau dibatalkan. Silakan buat booking baru jika ingin mencoba lagi.');
        }

        return redirect()->route('customer.bookings.index')
            ->with('error', 'Pembayaran gagal. Silakan coba kembali.');
    }

    public function storeComment(Request $request, Booking $booking)
    {
        if ($booking->id_customer !== auth()->id()) {
            abort(403);
        }
        if ($booking->status_service !== 'completed') {
            return back()->with('error', 'Komentar hanya bisa diberikan untuk booking yang sudah selesai.');
        }

        $request->validate([
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'required|string|max:500',
        ]);

        $existing = Comment::where('id_customer', auth()->id())
            ->where('id_terapis', $booking->id_terapis)->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan komentar untuk terapis ini.');
        }

        Comment::create([
            'id_customer' => auth()->id(),
            'id_terapis'  => $booking->id_terapis,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
        ]);

        $avgRating = Comment::where('id_terapis', $booking->id_terapis)->avg('rating');
        Terapis::where('id', $booking->id_terapis)->update(['rating' => round($avgRating, 2)]);

        return back()->with('success', 'Terima kasih atas rating dan komentar Anda!');
    }
}
