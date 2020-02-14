<?php


namespace App\Helpers;


use Illuminate\Http\Request;

class JsonDecoder
{
    public function createWallet(Request $request)
    {
        if(!$json = $this->checkJsonSignature($request, 'wallet'))
            return false;

        if (array_diff_key(array_flip(['mobile_number', 'balance']), $json))
            return false;

        return $json;
    }


    public function applyDiscountRequest(Request $request)
    {
        if(!$json = $this->checkJsonSignature($request, 'applyDiscount'))
            return false;

        if (array_diff_key(array_flip(['mobile_number', 'code']), $json))
            return false;

        return $json;
    }


    private function checkJsonSignature(Request $request, $fieldName)
    {
        if(!$request->has($fieldName))
            return false;

        $json =  json_decode($request->get($fieldName), true);
        if(json_last_error() != JSON_ERROR_NONE)
            return false;
        return $json;
    }
}
