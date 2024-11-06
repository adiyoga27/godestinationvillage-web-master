<?php
 
return [
    'mercant_id' => env('MIDTRANS_MERCHAT_ID'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'uri' => env('MIDTRANS_URI_SANDBOX'),
 
    'is_production' => env('MIDTRANS_MERCHAT_PRODUCTION'),
    'is_sanitized' => env('MIDTRANS_MERCHAT_SANITIZED'),
    'is_3ds' => env('MIDTRANS_MERCHAT_3DS'),
];