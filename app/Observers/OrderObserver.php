<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        try {
            $firebase = new FirebaseService();
            $notifData = [
                'created_at' => new \DateTime(),
                'deleted_by' => [],
                'owner_by' => [(int)$order->user_id],
                'read_by' => [],
                'reference' => '/transaction-detail/tour/' . $order->uuid,
                'subtitle' => 'Segera selesaikan pembayaran anda dengan nomor invoice "' . $order->code . '"',
                'title' => 'Payment Unpaid',
                'type' => 'transaction'
            ];
            $firebase->saveNotification($notifData);
            $firebase->sendFCM((string)$order->user_id, 'Payment Unpaid', 'Segera selesaikan pembayaran anda dengan nomor invoice "' . $order->code . '"');
        } catch (\Throwable $e) {
            Log::error("Firebase Error in OrderObserver: " . $e->getMessage());
        }
    }
}
