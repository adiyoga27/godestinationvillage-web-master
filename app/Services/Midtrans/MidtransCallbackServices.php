<?php

 
namespace App\Services\Midtraans;

use App\Models\Transaction;
use Midtrans\Config;
 
class MidtransCallbackServices {
    public static function payment($payload)
    {
        return Transaction::create($payload);
    }
}