<?php

namespace App\Http\Controllers;

use App\Mail\OrderEmail;
use App\Mail\OrderEventEmail;
use App\Mail\OrderHomestayEmail;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function checkEmail()
    {
        $order =  OrderEvent::latest()->first();
        $subject = 'Godevi - Order ' . $order->id . ' - Confirmation';
        $message = "This is your booking information, please make payment to confirm your reservation as following details(<a href='https://godestinationvillage.com/reservation/'>Details Order</a>) : <br> ";


        $email = new OrderEventEmail($subject, $order, $message);
        return $email;
    }
    public function checkHomeStay()
    {
        $order =  OrderHomestay::latest()->first();
        $subject = 'Godevi - Order ' . $order->id . ' - Confirmation';
        $message = "This is your booking information, please make payment to confirm your reservation as following details(<a href='https://godestinationvillage.com/reservation/'>Details Order</a>) : <br> ";


        $email = new OrderHomestayEmail($subject, $order, $message);
        return $email;
    }
    public function checkPackage()
    {
        $order =  Order::latest()->first();
        $subject = 'Godevi - Order ' . $order->id . ' - Confirmation';
        $message = "This is your booking information, please make payment to confirm your reservation as following details(<a href='https://godestinationvillage.com/reservation/'>Details Order</a>) : <br> ";


        $email = new OrderEmail($subject, $order, $message);
        return $email;
    }
}
