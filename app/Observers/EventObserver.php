<?php

namespace App\Observers;

use App\Models\Event;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function created(Event $event)
    {
        try {
            $firebase = new FirebaseService();
            $notifData = [
                'created_at' => new \DateTime(),
                'deleted_by' => [],
                'owner_by' => [], // Empty as per request for broadcast
                'read_by' => [],
                'reference' => 'events/' . $event->slug,
                'subtitle' => $event->name,
                'title' => 'Ada Event Baru nih',
                'type' => 'events'
            ];
            $firebase->saveNotification($notifData);
            
            // Send to 'all' topic
            $firebase->sendFCM('all', 'Ada Event Baru nih', $event->name);
            
        } catch (\Throwable $e) {
            Log::error("Firebase Error in EventObserver: " . $e->getMessage());
        }
    }
}
