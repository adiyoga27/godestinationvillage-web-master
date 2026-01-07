<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    protected $merchantID = "G092653477";
    protected $clientKey = "SB-Mid-client-9gnjzHEIyKcWoMsA";
    protected $serverKey = "SB-Mid-server-Oeq0isjIJQFm-pzPRbljXaDn";
    protected $expiry = 2;
    protected $urlCreate = "https://api.sandbox.midtrans.com/v2/charge";

    public function methodPayment(Request $request) {
        
    }
}
