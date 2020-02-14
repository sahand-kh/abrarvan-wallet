<?php


namespace App\Helpers;


use GuzzleHttp\Client;

class DiscountHelper
{
    public function requestDiscount($walletId, $code)
    {
        $jsonEncoder = new JsonEncoder();
        $client = new Client();
        $response = $client->post(env('DISCOUNT_SERVICE_URL'), [
            'form_params' => [
                'discount' => $jsonEncoder->applyDiscount($walletId, $code),
            ]
        ]);
        return $response;
    }
}
