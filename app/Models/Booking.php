<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'id_customer',
        'id_terapis',
        'id_location',
        'date_booking',
        'status_payment',
        'id_service',
        'id_waktu_boking',
        'id_ruangan',
        'status_service',
        'time_booking',
        'payment_proof',
        'payment_method',
        'snap_token',
        'midtrans_order_id',
        'booking_for',
        'second_username',
        'gender_second',
    ];

    protected function casts(): array
    {
        return [
            'date_booking' => 'date',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_customer');
    }

    public function terapis(): BelongsTo
    {
        return $this->belongsTo(Terapis::class, 'id_terapis');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class, 'id_location');
    }

    public function waktuBoking(): BelongsTo
    {
        return $this->belongsTo(\App\Models\WaktuBoking::class, 'id_waktu_boking');
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Ruangan::class, 'id_ruangan');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ServiceCategory::class, 'id_service');
    }

    public function getStatusPaymentLabelAttribute(): string
    {
        return match($this->status_payment) {
            'unpaid'                => 'Belum Bayar',
            'pending_snap'          => 'Menunggu Pembayaran',
            'waiting_confirmation'  => 'Menunggu Konfirmasi',
            'paid'                  => 'Lunas',
            'rejected'              => 'Ditolak',
            'expired'               => 'Kadaluarsa',
            default                 => $this->status_payment,
        };
    }

    public function getStatusServiceLabelAttribute(): string
    {
        return match($this->status_service) {
            'pending'     => 'Menunggu',
            'confirmed'   => 'Dikonfirmasi',
            'in_progress' => 'Sedang Berjalan',
            'completed'   => 'Selesai',
            'cancelled'   => 'Dibatalkan',
            default       => $this->status_service,
        };
    }

    public function getStatusPaymentBadgeAttribute(): string
    {
        return match($this->status_payment) {
            'paid'                  => 'success',
            'waiting_confirmation'  => 'warning',
            'pending_snap'          => 'info',
            'unpaid'                => 'secondary',
            'rejected'              => 'danger',
            'expired'               => 'dark',
            default                 => 'secondary',
        };
    }

    public function getStatusServiceBadgeAttribute(): string
    {
        return match($this->status_service) {
            'confirmed'   => 'success',
            'in_progress' => 'primary',
            'completed'   => 'dark',
            'pending'     => 'warning',
            'cancelled'   => 'danger',
            default       => 'secondary',
        };
    }
}
