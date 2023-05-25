<?php

use App\Mail\ContactUs;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// if(!file_exists(storage_path('installed'))){
// 	return redirect('/install');
// }



Route::get('contact-us-email', function () {
    $data = ['first_name' => 'Umar', 'last_name' => 'Aslam', 'email' => 'umar@abc.com', 'message' => 'lorem ipsum', 'phone' => ''];
    return (new ContactUs($data))->render();
});

// Route::get('install', function () {

// });

Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');

});

Route::any('admin/{all}', function () {
    return view('layouts.admin-master');
})
    ->where(['all' => '.*']);

    Route::group(['middleware' => ['general','installer']], function () {
        Route::get('/', function () {
            return redirect('/admin/login');
        });
    });
    
    Route::get('/hyperpay', 'Web\IndexController@getcall');

Route::group(['middleware' => ['general','installer']], function () {

   
    Route::get('set_currency/{currency}', 'Web\IndexController@setCurrency');
    
    Route::get('lang/{locale}', 'LocalizationController@index');
    

});

Route::group(['middleware' => ['general','installer']], function () {

    

    Route::get('set_currency/{currency}', 'Web\IndexController@setCurrency');
    Route::post('paytm-pay', 'Web\IndexController@paytmPayment');
    Route::post('paytm_response', 'Web\IndexController@paytmResponse');
    Route::get('mollie-payment/{order_id}', 'Web\IndexController@molliePayment');
    Route::post('mollie-webhook', 'Web\IndexController@mollieWebHook');

    Route::get('order-web-view', 'Web\IndexController@orderWebView');
    Route::get('lang/{locale}', 'LocalizationController@index');

    Route::get('/payment-paystck/callback', 'Web\IndexController@handleGatewayCallback')->name('payment');
    Route::get('/payment-desgin',function(){
        return view('paymentdesign');
    });
    Route::get('update-settings-by-user', 'Web\IndexController@updateSettingsByUser');
    
    Route::get('reset-accounts', 'Web\IndexController@seedFromExistingData');
    Route::get('points', 'Web\IndexController@points');



    

    

});
