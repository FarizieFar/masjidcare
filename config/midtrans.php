<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'sandbox_client_key' => env('MIDTRANS_SANDBOX_CLIENT_KEY'),
    'sandbox_server_key' => env('MIDTRANS_SANDBOX_SERVER_KEY'),
    'sandbox_url' => env('MIDTRANS_SANDBOX_URL'),
    'production_url' => env('MIDTRANS_PRODUCTION_URL'),
    'production_client_key' => env('MIDTRANS_PRODUCTION_CLIENT_KEY'),
    'production_server_key' => env('MIDTRANS_PRODUCTION_SERVER_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION')
];