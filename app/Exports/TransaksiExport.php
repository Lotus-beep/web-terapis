<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = Booking::with(['customer', 'terapis', 'service']);

        if ($this->request->status_service) {
            $query->where('status_service', $this->request->status_service);
        }

        if ($this->request->status_payment) {
            $query->where('status_payment', $this->request->status_payment);
        }

        if ($this->request->date_booking) {
            $query->where('date_booking', $this->request->date_booking);
        }

        return view('exports.transaksi', [
            'bookings' => $query->orderBy('created_at', 'desc')->get()
        ]);
    }
}
