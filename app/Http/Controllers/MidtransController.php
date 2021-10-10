<?php

namespace App\Http\Controllers;

use App\Services\Midtraans\MidtransCallbackServices;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callbackPayment(Request $request)
    {
        return MidtransCallbackServices::payment($request->toArray());
    }
}
