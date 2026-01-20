<?php

namespace App\Observers;

use App\Models\Package;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class PackageObserver
{
    /**
     * Handle the Package "created" event.
     *
     * @param  \App\Models\Package  $package
     * @return void
     */
    public function created(Package $package)
    {
        try {
            $firebase = new FirebaseService();
            $notifData = [
                'created_at' => new \DateTime(),
                'deleted_by' => [],
                'owner_by' => [], // Empty means broadcast to all/public
                'read_by' => [],
                'reference' => 'tours/' . $package->slug,
                'subtitle' => $package->name, // Using name as subtitle
                'title' => 'Paket Tour Baru',
                'type' => 'tours'
            ];
            $firebase->saveNotification($notifData);
            
            // Send to 'all' topic
            $firebase->sendFCM('all', 'Paket Tour Baru', $package->name);
            
        } catch (\Throwable $e) {
            Log::error("Firebase Error in PackageObserver: " . $e->getMessage());
        }
    }
}
