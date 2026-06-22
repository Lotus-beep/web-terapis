<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        if (!class_exists('\Midtrans\Config')) {
            throw new \RuntimeException(
                'Midtrans SDK belum terinstall. Jalankan: composer require midtrans/midtrans-php'
            );
        }

        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;
    }

    /**
     * Buat Snap token untuk booking
     */
    public function createSnapToken(Booking $booking): string
    {
        $orderId = 'RBS-' . $booking->id . '-' . time();

        $booking->update(['midtrans_order_id' => $orderId]);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $booking->service->price,
            ],
            'customer_details' => [
                'first_name' => $booking->customer->username,
                'email'      => $booking->customer->email,
                'phone'      => $booking->customer->no_telepon ?? '',
            ],
            'item_details' => [
                [
                    'id'       => (string) $booking->service->id,
                    'price'    => (int) $booking->service->price,
                    'quantity' => 1,
                    'name'     => substr($booking->service->name, 0, 50),
                ],
            ],
            // Tidak set callbacks di sini — pakai URL dari Midtrans Dashboard
            // Finish: https://xxx.ngrok-free.app/payment/finish
            // Error:  https://xxx.ngrok-free.app/payment/error
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $booking->update([
            'snap_token'     => $snapToken,
            'status_payment' => 'pending_snap',
        ]);

        return $snapToken;
    }

    /**
     * Cek status transaksi langsung ke Midtrans API
     * Digunakan saat user kembali dari halaman pembayaran
     */
    public function checkTransactionStatus(string $orderId): ?array
    {
        try {
            $status = \Midtrans\Transaction::status($orderId);
            return (array) $status;
        } catch (\Exception $e) {
            Log::error('Midtrans checkTransactionStatus error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Proses status dan update booking
     * Dipakai oleh webhook maupun finish callback
     */
    public function processStatus(Booking $booking, string $transactionStatus, string $fraudStatus = ''): void
    {
        Log::info('Midtrans processStatus', [
            'booking_id'         => $booking->id,
            'order_id'           => $booking->midtrans_order_id,
            'transaction_status' => $transactionStatus,
            'fraud_status'       => $fraudStatus,
        ]);

        match(true) {
            // Pembayaran berhasil — capture (kartu kredit)
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => $this->markPaid($booking),

            // Pembayaran berhasil — settlement (transfer bank, e-wallet, dll)
            $transactionStatus === 'settlement' => $this->markPaid($booking),

            // Pembayaran dibatalkan / ditolak / gagal
            in_array($transactionStatus, ['cancel', 'deny', 'failure']) => $booking->update([
                'status_payment' => 'rejected',
                'status_service' => 'cancelled',
            ]),

            // Kadaluarsa
            $transactionStatus === 'expire' => $booking->update([
                'status_payment' => 'expired',
                'status_service' => 'cancelled',
            ]),

            // Menunggu pembayaran
            $transactionStatus === 'pending' => $booking->update([
                'status_payment' => 'pending_snap',
            ]),

            default => null,
        };
    }

    /**
     * Tandai booking sebagai PAID dan otomatis confirm service
     */
    private function markPaid(Booking $booking): void
    {
        $booking->update([
            'status_payment' => 'paid',
            'status_service' => 'confirmed', // Otomatis confirmed setelah bayar
        ]);

        Log::info('Booking #' . $booking->id . ' status_payment=paid, status_service=confirmed');
    }

    /**
     * Handle Midtrans webhook notification (POST dari server Midtrans)
     */
    public function handleNotification(): void
    {
        $notification = new \Midtrans\Notification();

        $orderId           = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus       = $notification->fraud_status ?? '';

        $booking = Booking::where('midtrans_order_id', $orderId)->first();
        if (!$booking) {
            Log::warning('Midtrans webhook: booking not found for order_id=' . $orderId);
            return;
        }

        $this->processStatus($booking, $transactionStatus, $fraudStatus);
    }
}
