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

//Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function() {
    Route::prefix('Sale')->group(function () {
        Route::resource('/', Sale\SaleInvoiceController::class);
        Route::resource('acc_ticket', Sale\TicketController::class);
        Route::post('get_ticket_inv', 'Sale\TicketController@index');

        Route::resource('acc_hotel', Sale\HotelController::class);
        Route::post('get_hotel_inv', 'Sale\HotelController@index');

        Route::resource('acc_visa', Sale\VisaController::class);
        Route::post('get_visa_inv', 'Sale\VisaController@index');

        Route::resource('acc_transport', Sale\TransportController::class);
        Route::post('get_transport_inv', 'Sale\TransportController@index');
        //tour sale
        Route::post('tour_ticket_store', 'Sale\TourController@ticket_store');
        Route::post('tour_hotel_store', 'Sale\TourController@hotel_store');
        Route::post('tour_visa_store', 'Sale\TourController@visa_store');
        Route::post('tour_transport_store', 'Sale\TourController@transport_store');
        Route::post('tour_other_store', 'Sale\TourController@other_store');
        Route::post('get_tour', 'Sale\TourController@index');

        Route::resource('acc_other', Sale\OtherSaleController::class);
        Route::post('get_other_inv', 'Sale\OtherSaleController@index');
        //fetch customers
        Route::get('fetch_customers/{type}', 'Sale\SaleInvoiceController@fetch_customers');
    });

});


