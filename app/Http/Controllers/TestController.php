<?php

namespace App\Http\Controllers;

use App\Mail\OrderEmail;
use App\Models\Order;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testEmail()
    {
        $order =  Order::latest()->first();
        $subject = 'Godevi - Order ' . $order->id . ' - Confirmation';
        $message = "This is your booking information, please make payment to confirm your reservation as following details(<a href='https://godestinationvillage.com/reservation/>Details Order</a>) : <br> Note: We will proces your booking after we receive your payment. This can take up to 24 hours to verify your payment. After the verification you will get the e-tour voucher through email";


        $email = new OrderEmail($subject, $order, $message);
        return $email;
    }
}
