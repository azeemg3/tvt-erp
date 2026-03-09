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
Route::get('gen_int_tour_voucher/{id}','Bookings\BookingControlller@gen_int_tour_voucher');
Auth::routes();

//Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function() {
    Route::prefix('bookings')->group(function () {
        Route::get('/','Bookings\BookingControlller@index');
        Route::get('tour_booking','Bookings\BookingControlller@tour_booking');
        Route::post('get_tour_booking','Bookings\BookingControlller@get_tour_booking');
        Route::get('tour_booking_details/{id}','Bookings\BookingControlller@tour_booking_details');
        Route::get('app_int_tour/{id}','Bookings\BookingControlller@app_int_tour');
        Route::post('save_tour_pax','Bookings\BookingControlller@save_pax');
        Route::post('get_tour_pax','Bookings\BookingControlller@get_tour_pax');
        Route::delete('delete_tour_pax/{id}','Bookings\BookingControlller@delete_pax');
    });

});



