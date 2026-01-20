<?php

namespace App\Observers;

use App\Models\OrderHomestay;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class OrderHomestayObserver
{
    /**
     * Handle the OrderHomestay "created" event.
     *
     * @param  \App\Models\OrderHomestay  $orderHomestay
     * @return void
     */
    public function created(OrderHomestay $orderHomestay)
    {
        try {
            $firebase = new FirebaseService();
            $notifData = [
                'created_at' => new \DateTime(),
                'deleted_by' => [],
                'owner_by' => [(int)$orderHomestay->user_id],
                'read_by' => [],
                'reference' => '/transaction-detail/homestay/' . $orderHomestay->uuid,
                'subtitle' => 'Segera selesaikan pembayaran anda dengan nomor invoice "' . $orderHomestay->code . '"',
                'title' => 'Payment Unpaid',
                'type' => 'transaction'
            ];
            $firebase->saveNotification($notifData);
            $firebase->sendFCM((string)$orderHomestay->user_id, 'Payment Unpaid', 'Segera selesaikan pembayaran anda dengan nomor invoice "' . $orderHomestay->code . '"');
        } catch (\Throwable $e) {
            Log::error("Firebase Error in OrderHomestayObserver: " . $e->getMessage());
        }
    }
}
