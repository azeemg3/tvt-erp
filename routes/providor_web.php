<?php
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
Auth::routes();
Route::group(['middleware' => ['auth','role:Providor']], function() {
    Route::prefix('providors')->group(function () {
        Route::get('/','Providors\DashboardController@index');
        Route::resource('hotel_providor',Providors\HotelController::class);
        Route::post('get_hotel_providor','Providors\HotelController@get_data');
        Route::resource('visa_providor',Providors\VisaController::class);
        Route::resource('transport_providor',Providors\TransportController::class);
        Route::post('get_transport_providor','Providors\TransportController@get_data');
        Route::prefix('accounts')->group(function (){
            Route::get('account_statement','Providors\AccountController@index');
            Route::post('get_account_statement','Providors\AccountController@get_data');
        });
    });
});


