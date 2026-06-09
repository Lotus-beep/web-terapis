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
        'date_booking',
        'status_payment',
        'id_service',
        'status_service',
        'time_booking',
        'payment_proof',
        'payment_method',
        'snap_token',
        'midtrans_order_id',
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

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service');
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
