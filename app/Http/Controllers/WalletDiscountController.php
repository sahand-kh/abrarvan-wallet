<?php

namespace App\Http\Controllers;

use App\Helpers\DiscountHelper;
use App\Helpers\JsonDecoder;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletDiscountController extends Controller
{
    public function applyDiscount(Request $request)
    {
        //Todo: make a job for this functionality
        if ($json = (new JsonDecoder())->applyDiscountRequest($request)):
            $wallet = $this->getWallet($json['mobile_number']);

            $response = (new DiscountHelper())->requestDiscount($wallet->id, $json['code']);
            if($response->getStatusCode() != 200)
                return "operation failure";
            $responseJson = json_decode($response->getBody(), true);

            if ($responseJson['status']):
                $wallet->balance += $responseJson['value'];
                $wallet->save();
            endif;

            return $responseJson['message'];
        endif;
        return "json format is invalid";
    }


    private function getWallet($mobileNUmber)
    {
        $wallet = Wallet::where('mobile_number', $mobileNUmber)->first();
        if (!$wallet)
            $wallet = $this->createNewWallet($mobileNUmber);
        return $wallet;
    }


    private function createNewWallet($mobileNumber)
    {
        return Wallet::create([
            'mobile_number' => $mobileNumber,
            'balance' => 0,
        ]);
    }
}
