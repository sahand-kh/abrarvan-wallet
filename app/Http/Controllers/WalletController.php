<?php

namespace App\Http\Controllers;

use App\Helpers\JsonDecoder;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //Todo: add validation
            if ($json = (new JsonDecoder())->createWallet($request)):

                $wallet = new Wallet();
                if ($wallet->userWalletExists($json['mobile_number']))
                    return 'the wallet already exists';

                $wallet->create($json);
                return "wallet defined successfully";

            endif;
            return "json format is invalid";

        } catch (\Exception $e) {
            Log::error('wallet can not be defined ' . $e->getMessage());
            return "wallet can not be defined";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($mobileNumber)
    {
        $wallet = Wallet::where('mobile_number', $mobileNumber)->first();
        if ($wallet)
            return json_encode($wallet);
        return "no such a wallet";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            if ($json = (new JsonDecoder())->createWallet($request)):

                $wallet = Wallet::where('mobile_number', $json['mobile_number'])->first();
                if (!$wallet)
                    return'No such a wallet exists';

                $wallet->fill(['balance' => $json['balance']])->save();
                return "wallet updated successfully";

            endif;
            return "json format is invalid";

        } catch (\Exception $e) {
            Log::error('wallet can not be updated ' . $e->getMessage());
            return "wallet can not be updated";
        }
    }

}
