<?php

namespace App\Services\Midtrans;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\Transaction;

class MidtransCallbackServices
{
    public static function payment($payload)
    {
        $status = 'pending';
        $invoice = $payload['order_id'];
        $payment_type = $payload['payment_type'];
        $transaction_time = $payload['transaction_time'];
        $status = $payload['transaction_status'];
        if ($status == 'capture') {
            //check Order Package
            $package = Order::where('code', $invoice)->first();
            if($package){
                Order::where('code', $invoice)->update(
                    [
                        'payment_status' => 'success',
                        'payment_type' => $payment_type,
                        'payment_date' => $transaction_time
                    ]
                );
            }

            //check Order Event
            $event = OrderEvent::where('code', $invoice)->first();
            if ($event) {
                OrderEvent::where('code', $invoice)->update(
                    [
                        'payment_status' => 'success',
                        'payment_type' => $payment_type,
                        'payment_date' => $transaction_time
                    ]
                );
            }
        }
        return Transaction::create($payload);
    }
}
