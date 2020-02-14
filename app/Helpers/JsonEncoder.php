<?php


namespace App\Helpers;


use Illuminate\Http\Request;

class JsonEncoder
{
    public function applyDiscount($walletID, $discountCode)
    {
        $applyDiscountRequest['wallet_id'] = $walletID;
        $applyDiscountRequest['code'] = $discountCode;

        return json_encode($applyDiscountRequest);
    }

}
