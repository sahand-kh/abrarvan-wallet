<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function (){
    return "Welcome to wallet micro system";
});



$router->post('wallet', 'WalletController@store');
$router->get('wallet/{mobileNumber}', 'WalletController@show');
$router->patch('wallet', 'WalletController@update');
$router->post('apply-discount', 'WalletDiscountController@applyDiscount');
