<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\Service;
use App\Models\Terapis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['terapis', 'service.location'])
            ->where('id_customer', auth()->id());

        if ($request->status_service) {
            $query->where('status_service', $request->status_service);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('customer.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $service = null;
        if ($request->service_id) {
            $service = Service::with(['terapis', 'location'])->findOrFail($request->service_id);
        }
        $services = Service::with(['terapis', 'location'])->where('status_payment', 'active')->get();
        return view('customer.bookings.create', compact('service', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_service'   => 'required|exists:service,id',
            'date_booking' => 'required|date|after_or_equal:today',
            'time_booking' => 'required',
        ]);

        $service = Service::findOrFail($request->id_service);

        Booking::create([
            'id_customer'    => auth()->id(),
            'id_terapis'     => $service->id_terapis,
            'id_service'     => $service->id,
            'date_booking'   => $request->date_booking,
            'time_booking'   => $request->time_booking,
            'status_payment' => 'unpaid',
            'status_service' => 'pending',
        ]);

        return redirect()->route('customer.bookings.index')->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function show(Booking $booking)
    {
        if ($booking->id_customer !== auth()->id()) {
            abort(403);
        }
        $booking->load(['terapis', 'service.location']);
        $hasComment = Comment::where('id_customer', auth()->id())
            ->where('id_terapis', $booking->id_terapis)->exists();
        return view('customer.bookings.show', compact('booking', 'hasComment'));
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

        // Update rata-rata rating terapis
        $avgRating = Comment::where('id_terapis', $booking->id_terapis)->avg('rating');
        \App\Models\Terapis::where('id', $booking->id_terapis)->update(['rating' => round($avgRating, 2)]);

        return back()->with('success', 'Terima kasih atas rating dan komentar Anda!');
    }
}
