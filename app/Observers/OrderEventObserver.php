<?php

namespace App\Observers;

use App\Models\OrderEvent;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class OrderEventObserver
{
    /**
     * Handle the OrderEvent "created" event.
     *
     * @param  \App\Models\OrderEvent  $orderEvent
     * @return void
     */
    public function created(OrderEvent $orderEvent)
    {
        try {
            $firebase = new FirebaseService();
            $notifData = [
                'created_at' => new \DateTime(),
                'deleted_by' => [],
                'owner_by' => [(int)$orderEvent->user_id],
                'read_by' => [],
                'reference' => '/transaction-detail/event/' . $orderEvent->uuid,
                'subtitle' => 'Segera selesaikan pembayaran anda dengan nomor invoice "' . $orderEvent->code . '"',
                'title' => 'Payment Unpaid',
                'type' => 'transaction'
            ];
            $firebase->saveNotification($notifData);
            $firebase->sendFCM((string)$orderEvent->user_id, 'Payment Unpaid', 'Segera selesaikan pembayaran anda dengan nomor invoice "' . $orderEvent->code . '"');
        } catch (\Throwable $e) {
            Log::error("Firebase Error in OrderEventObserver: " . $e->getMessage());
        }
    }
}
