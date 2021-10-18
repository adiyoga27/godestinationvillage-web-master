<?php

namespace App\Services\Midtrans;

use App\Mail\OrderEmail;
use App\Mail\OrderEventEmail;
use App\Mail\OrderHomestayEmail;
use App\Models\Event;
use App\Models\Homestay;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use App\Models\Transaction;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class MidtransCallbackServices
{
    public static function payment($payload)
    {
       $dataTransaction =  Transaction::create($payload);
        $status = 'pending';
        $invoice = $payload['order_id'];
        $payment_type = $payload['payment_type'];
        $transaction_time = $payload['transaction_time'];
        $status = $payload['transaction_status'];
        if ($status == 'capture' || $status == 'settlement') {
            //check Order Package
            $result = false;
            $prefix = substr($invoice,0,3);

            if($prefix == 'INV'){
               $result = Order::where('code', $invoice)->update(
                    [
                        'payment_status' => 'success',
                        'payment_type' => $payment_type,
                        'payment_date' => $transaction_time
                    ]
                );
                if($result){
                    MidtransCallbackServices::sendEmailNotification($invoice, 'package');
                }
            }

            //check Order Event
            if ($prefix == 'EVT') {
               $result = OrderEvent::where('code', $invoice)->update(
                    [
                        'payment_status' => 'success',
                        'payment_type' => $payment_type,
                        'payment_date' => $transaction_time
                    ]
                );
                if($result){
                    MidtransCallbackServices::sendEmailNotification($invoice, 'event');
                }
            }

             //check Order Home Stay
             if ($prefix == 'HST') {
                $result = OrderHomestay::where('code', $invoice)->update(
                     [
                         'payment_status' => 'success',
                         'payment_type' => $payment_type,
                         'payment_date' => $transaction_time
                     ]
                 );
                 if($result){
                    MidtransCallbackServices::sendEmailNotification($invoice, 'homestay');
                }
             }

           
        }
        return $dataTransaction;
    }
    public static function sendEmailNotification($invoice, $type)
    {

        $subject = 'Godevi - Order '. $invoice .' - Success';
        $message = "We have received your Order and Payment, here are your order details: <br> ";
        if($type == 'package'){
            $order = Order::where('code', $invoice)->first();
            if($order){
                $email = new OrderEmail($subject, $order, $message);
                Mail::to([$order->customer_email])->send($email);
            }
        }
        if($type == 'event'){
            $order = OrderEvent::where('code', $invoice)->first();
            if($order){
                $email = new OrderEventEmail($subject, $order, $message);
                Mail::to([$order->customer_email])->send($email);
            }
        }
        if($type == 'homestay'){
            $order = OrderHomestay::where('code', $invoice)->first();
            if($order){
                $email = new OrderHomestayEmail($subject, $order, $message);
                Mail::to([$order->customer_email])->send($email);
            }
        }
     

    }
}
