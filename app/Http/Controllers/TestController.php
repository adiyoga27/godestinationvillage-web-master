<?php

namespace App\Http\Controllers;

use App\Mail\OrderEmail;
use App\Mail\OrderEventEmail;
use App\Models\Order;
use App\Models\OrderEvent;
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
}
