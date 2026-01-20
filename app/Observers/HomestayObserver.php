<?php

namespace App\Observers;

use App\Models\Homestay;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class HomestayObserver
{
    /**
     * Handle the Homestay "created" event.
     *
     * @param  \App\Models\Homestay  $homestay
     * @return void
     */
    public function created(Homestay $homestay)
    {
        try {
            $firebase = new FirebaseService();
            $notifData = [
                'created_at' => new \DateTime(),
                'deleted_by' => [],
                'owner_by' => [], // Empty means broadcast to all/public
                'read_by' => [],
                'reference' => 'homestay/' . $homestay->slug,
                'subtitle' => $homestay->name, // Using name as subtitle
                'title' => 'Homestay baru',
                'type' => 'homestay'
            ];
            $firebase->saveNotification($notifData);
            
            // Send to 'all' topic
            $firebase->sendFCM('all', 'Homestay baru', $homestay->name);
            
        } catch (\Throwable $e) {
            Log::error("Firebase Error in HomestayObserver: " . $e->getMessage());
        }
    }
}
