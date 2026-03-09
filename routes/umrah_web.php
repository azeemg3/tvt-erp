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
    Route::prefix('umrah')->group(function () {
        Route::resource('group_details', Umrah\GroupDetailController::class);
        Route::post('save_group_excel', 'Umrah\GroupDetailController@save_group_excel');
        Route::post('save_visitor_excel', 'Umrah\GroupDetailController@save_visitor_excel');
        Route::post('get_group_details', 'Umrah\GroupDetailController@get_data');
        Route::resource('mofa_list', Umrah\MofaController::class);
        Route::post('save_visitor', 'Umrah\GroupDetailController@save_visitor');
        Route::delete('remove_visitor/{id}','Umrah\GroupDetailController@remove_visitor');
        Route::post('get_visitor_data', 'Umrah\GroupDetailController@get_visitor_data');
        Route::get('edit_pax/{id}', 'Umrah\GroupDetailController@edit_pax');
        Route::post('save_mofa_details', 'Umrah\GroupDetailController@save_mofa_details');
        Route::resource('hotel_reservation',Umrah\HotelReservationController::class);
        Route::post('get_hotel_reservation','Umrah\HotelReservationController@get_data');
        Route::resource('transport_reservation',Umrah\TransportReservationController::class);
        Route::post('get_transport_reservation','Umrah\TransportReservationController@get_data');
        Route::post('save_hotelbrn','Umrah\GroupDetailController@save_hotelbrn');
        Route::post('save_transportbrn','Umrah\GroupDetailController@save_transportbrn');
        Route::resource('transport_company',Umrah\TransportCompanyController::class);
        Route::resource('ground_services',Umrah\GroundServiceController::class);
        Route::post('save_group_det_service','Umrah\GroupDetailController@save_group_service');
        Route::post('save_group_voucher','Umrah\GroupDetailController@save_group_voucher');
        //@edit group voucher
        Route::get('edit_gv/{id}', 'Umrah\GroupDetailController@edit_gv');
        Route::get('edit_hotelBrn/{id}', 'Umrah\GroupDetailController@edit_hotelBrn');
        Route::get('edit_gground_service/{id}', 'Umrah\GroupDetailController@edit_gground_service');
        Route::get('edit_transportBrn/{id}', 'Umrah\GroupDetailController@edit_transportBrn');
        Route::resource('transport_cycle',Umrah\TransportCycleController::class);
        Route::post('get_transport_cycle','Umrah\TransportCycleController@get_data');
        Route::get('fetch_available_capacity/{brn}','Umrah\GroupDetailController@fetch_available_capacity');
        Route::get('fetchHotel_available_capacity/{brn}','Umrah\GroupDetailController@fetchHotel_available_capacity');
    });

});


