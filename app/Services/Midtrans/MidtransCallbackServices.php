<?php
namespace App\Services\Midtrans;

use App\Models\Transaction;
 
class MidtransCallbackServices {
    public static function payment($payload)
    {
        return Transaction::create($payload);
    }
}