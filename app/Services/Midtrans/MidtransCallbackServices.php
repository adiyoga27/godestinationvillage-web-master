<?php

namespace App\Services\Midtrans;

use App\Helpers\BotHelper;
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
            $date = date('d M Y H:i', strtotime($transaction_time))." wita";
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
                    BotHelper::sendTelegram("Godevi - Payment Tour Package Success, \n\nDate: $date \nInvoice : $invoice \nPayment Type : $payment_type.\n");

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
                    BotHelper::sendTelegram("Godevi - Payment Event Success, \n\nDate: $date \nInvoice : $invoice \nPayment Type : $payment_type.\n");

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
                    BotHelper::sendTelegram("Godevi - Payment Homestay Success, \n\nDate: $date \nInvoice : $invoice \nPayment Type : $payment_type.\n");

                }
             }

           
        }
        return $dataTransaction;
    }
    public static function sendEmailNotification($invoice, $type)
    {
        if($type == 'package'){
            $order = Order::where('code', $invoice)->first();
            $customer_name = $order->customer_name;
            $village_name = $order->village_name;
            $message = "Hi $customer_name <br>We are pleased to inform you that your payment has been verified and your order has been forwarded to $village_name <br><br> Thank you for supporting tourism villages! Be ready to feel the most authentic village experiences.";
            $subject = 'Godevi - Order Tour Package '. $invoice .' - Success';
            if($order){
                $email = new OrderEmail($subject, $order, $message);
                Mail::to([$order->customer_email])->send($email);
            }
        }
        if($type == 'event'){
            $order = OrderEvent::where('code', $invoice)->first();
            $customer_name = $order->customer_name;
            // $event_name = $order->event_name;
            $message = "Hi $customer_name <br>We are pleased to inform you that your payment has been verified and your order has been forwarded processed <br><br> Thank you for supporting tourism villages! Be ready to feel the most authentic village experiences.";
            $subject = 'Godevi - Order Event '. $invoice .' - Success';
            if($order){
                $email = new OrderEventEmail($subject, $order, $message);
                Mail::to([$order->customer_email])->send($email);
            }
        }
        if($type == 'homestay'){
            $order = OrderHomestay::where('code', $invoice)->first();

            $customer_name = $order->customer_name;
            // $homestay_name = $order->homestay_name;
            $message = "Hi $customer_name <br>We are pleased to inform you that your payment has been verified and your order has been forwarded processed <br><br> Thank you for supporting tourism villages! Be ready to feel the most authentic village experiences.";
            $subject = 'Godevi - Order Homestay '. $invoice .' - Success';
            if($order){
                $email = new OrderHomestayEmail($subject, $order, $message);
                Mail::to([$order->customer_email])->send($email);
            }
        }
     

    }

    public static function sendEmailNotificationVillage($invoice, $type)
    {
        if($type == 'package'){
            $order = Order::with(['village'])->where('code', $invoice)->first();
            $village_name = $order->village->village_name;


            $message = "Dear $village_name <br>village_name<br><br>We are pleased to inform you, that you have a reservation as follows:";
            $subject = 'Godevi - Order Tour Package '. $invoice .' - Success';
            if($order){
                $email = new OrderEmail($subject, $order, $message);
                Mail::to([$order->customer_email])->send($email);
            }
        }
        if($type == 'event'){
            $order = OrderEvent::where('code', $invoice)->first();
            $customer_name = $order->customer_name;
            // $event_name = $order->event_name;
            $message = "Hi $customer_name <br>We are pleased to inform you that your payment has been verified and your order has been forwarded processed <br><br> Thank you for supporting tourism villages! Be ready to feel the most authentic village experiences.";
            $subject = 'Godevi - Order Event '. $invoice .' - Success';
            if($order){
                $email = new OrderEventEmail($subject, $order, $message);
                Mail::to([$order->customer_email])->send($email);
            }
        }
        if($type == 'homestay'){
            $order = OrderHomestay::where('code', $invoice)->first();

            $customer_name = $order->customer_name;
            // $homestay_name = $order->homestay_name;
            $message = "Hi $customer_name <br>We are pleased to inform you that your payment has been verified and your order has been forwarded processed <br><br> Thank you for supporting tourism villages! Be ready to feel the most authentic village experiences.";
            $subject = 'Godevi - Order Homestay '. $invoice .' - Success';
            if($order){
                $email = new OrderHomestayEmail($subject, $order, $message);
                Mail::to([$order->customer_email])->send($email);
            }
        }
     

    }
}
