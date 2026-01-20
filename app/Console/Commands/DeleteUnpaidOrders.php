<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-unpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Soft delete unpaid orders older than 24 hours and set status to cancel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting to delete unpaid orders older than 24 hours...');
        
        $cutoffTime = Carbon::now()->subHours(24);
        
        // Process Orders
        $orders = Order::where('payment_status', 'pending')
                    ->where('created_at', '<=', $cutoffTime)
                    ->get();
        
        $this->processOrders($orders, 'Tour Order');

        // Process Order Events
        $orderEvents = OrderEvent::where('payment_status', 'pending')
                        ->where('created_at', '<=', $cutoffTime)
                        ->get();

        $this->processOrders($orderEvents, 'Event Order');

        // Process Order Homestays
        $orderHomestays = OrderHomestay::where('payment_status', 'pending')
                            ->where('created_at', '<=', $cutoffTime)
                            ->get();

        $this->processOrders($orderHomestays, 'Homestay Order');

        $this->info('Completed deleting unpaid orders.');
        return 0;
    }

    private function processOrders($orders, $type)
    {
        $count = $orders->count();
        if ($count > 0) {
            $this->info("Found {$count} unpaid {$type}(s). Processing...");
            
            foreach ($orders as $order) {
                try {
                    // Update status to cancel
                    $order->payment_status = 'cancel';
                    $order->save();
                    
                    // Soft delete
                    $order->delete();
                    
                    $this->info("{$type} ID {$order->id} (Code: {$order->code}) cancelled and deleted.");
                } catch (\Exception $e) {
                    $this->error("Failed to process {$type} ID {$order->id}: " . $e->getMessage());
                    Log::error("Failed to process {$type} ID {$order->id}: " . $e->getMessage());
                }
            }
        } else {
            $this->info("No unpaid {$type}(s) found to delete.");
        }
    }
}
