<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'bulksms' => [
        'secret' => env('BULKSMS_SECRET'),
        'url' => env('BULKSMS_BASIC_URL'),
        'token_id' => env('BULKSMS_TOKEN_ID'),
    ],

    'egyptlinx' => [
        'provider' => env('EGYPTLINX_SMS_PROVIDER'),
        'password' => env('EGYPTLINX_SMS_PASSWORD'),
        'sender'   => env('EGYPTLINX_SMS_SENDER'),
    ],

    'paymob' => [
        'api_key'               => env('PAYMOB_API_KEY'),
        'intention_url'         => env('PAYMOB_INTENTION_URL', 'https://accept.paymob.com/v1/intention/'),
        'card_integration_id'   => env('PAYMOB_CARD_INTEGRATION_ID', '4991596'),
        'wallet_integration_id' => env('PAYMOB_WALLET_INTEGRATION_ID', '4991600'),
        'hmac_secret'           => env('PAYMOB_HMAC_SECRET'),
        'iframe_id'             => env('PAYMOB_IFRAME_ID'),
        'secret'                => env('PAYMOB_SK'),
        'public'                => env('PAYMOB_PK'),
    ],
    'firebase' => [
        'credentials' => env('FIREBASE_CREDENTIALS'),
        'project_id'  => env('FIREBASE_PROJECT_ID'),
    ]
];
