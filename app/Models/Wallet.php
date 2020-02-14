<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'mobile_number', 'balance'
    ];

    public function userWalletExists($mobileNumber)
    {
        return $this->where('mobile_number', $mobileNumber)->exists();
    }
}
