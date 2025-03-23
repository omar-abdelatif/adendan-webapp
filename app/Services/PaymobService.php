<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymobService
{

    protected $apiKey;
    protected $integrationId;
    protected $iframeId;
    protected $intentionUrl;

    public function __construct()
    {
        $this->integrationId = config('paymob.integration_id');
        $this->intentionUrl = config('paymob.intention_url');
    }

    public function createIntention($amount, $currency = 'EGP', $mobile_number = null, $first_name = null, $last_name = null,)
    {
        $response = Http::post($this->intentionUrl, [
            'api_key' => $this->apiKey,
            'amount_cents' => $amount * 100,
            'currency' => $currency,
            'payment_methods' => ['card', 'wallet'],
            'mobile_number' => $mobile_number,
            'email' => 'user@adendan.com',
            'first_name' => $first_name,
            'last_name' => $last_name,
            'integration_id' => $this->integrationId,
        ]);

        return $response->json();
    }
}
