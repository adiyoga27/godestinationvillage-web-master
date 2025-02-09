<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'http://localhost:8000/midtrans/callbackPayment',
        'http://godevi.codingaja.com/midtrans/callbackPayment',
        'https://godevi.codingaja.com/midtrans/callbackPayment',
        'https://godestinationvillage.com/midtrans/callbackPayment',
        'http://godestinationvillage.com/midtrans/callbackPayment',


    ];
}
