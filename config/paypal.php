<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'live' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
        'app_id'            => 'APP-80W284485P519543T',
    ],
    'sandbox' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', 'ActaDBFUYGEPVnNTSh3eu6MM-2bbyFHgbVmfKorEcxU1IB4rH172SAsCfTQw-LIuVvvwP11noG3-MumY'),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', 'EMWn9kypFAdX2LPdvLqckADpEV4ikNZyMesqpky24ZovTGts6zug5rVM0DyExROb2MVrjL2kYOUxpRgY'),
        'app_id'            => env('PAYPAL_LIVE_APP_ID', 'DOAN'),
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
    'locale'         => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', false), // Validate SSL when creating api client.
];
