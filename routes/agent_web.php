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
    Route::prefix('agent_management')->group(function () {
        Route::resource('subadmin',Agents\SubAdminController::class);
        Route::post('get_subadmin','Agents\SubAdminController@get_data');
        Route::resource('agent',Accounts\AgentController::class);
        Route::post('get_agents','Accounts\AgentController@get_data');
        Route::resource('go',Agents\GoController::class);
        Route::post('get_go','Agents\GoController@get_data');
        Route::resource('agent_price',Agents\AgentPriceController::class);
        Route::post('get_agent_price','Agents\AgentPriceController@get_data');
        Route::resource('orders',Agents\OrderController::class);
        Route::post('get_orders','Agents\OrderController@get_data');
        Route::resource('inquires',Agents\InquiriesController::class);
        Route::post('get_inquires','Agents\InquiriesController@get_data');
        Route::resource('agent_wallet',Agents\AgentWalletController::class);
        Route::post('get_agent_wallet','Agents\AgentWalletController@get_data');
        Route::get('approve_wallet/{id}','Agents\AgentWalletController@approve_wallet');
        Route::resource('agent_umrah',Agents\AgentUmrahController::class);
        Route::post('get_agent_umrah','Agents\AgentUmrahController@get_data');
        //fetch hotel agisnt agent id
        Route::get('get_agent_hotel/{id}/{city}','Agents\AgentUmrahController@get_agent_hotel');
        Route::post('approve_uv','Agents\AgentUmrahController@approve_uv');
        Route::get('umrah_details/{id}','Agents\AgentUmrahController@umrah_details');
        Route::get('fetch_agent_visitors/{id}','Agents\AgentUmrahController@fetch_agent_visitors');
        Route::post('assigned_visitors','Agents\AgentUmrahController@assigned_visitors');
        Route::post('search_transport_availability','Agents\AgentUmrahController@search_transport_availability');
        Route::post('search_hotel_availability','Agents\AgentUmrahController@search_hotel_availability');
        Route::resource('umrah_draft', Agents\UmrahDraftController::class);
        Route::post('get_umrah_draft', 'Agents\UmrahDraftController@get_data');
        //agent umrah pax details
        Route::post('save_umrah_pax', 'Agents\AgentUmrahController@pax_save');
        Route::get('edit_upax/{id}', 'Agents\AgentUmrahController@edit_upax');
        Route::delete('save_umrah_pax/remove/{id}', 'Agents\AgentUmrahController@remove_upax');
        //fetch hotel rates
        Route::post('fetch_hotel_rate', 'Agents\AgentUmrahController@fetch_hotel_rate');
        Route::post('fetch_transport_rate', 'Agents\AgentUmrahController@fetch_transport_rate');
        Route::get('fetch_visa_rate/{type}/{agentID?}', 'Agents\AgentUmrahController@fetch_visa_rate');
        Route::get('get_ground_handleservices/{id}', 'Agents\AgentUmrahController@get_ground_handleservices');
        Route::resource('custom_pkg_discount',Agents\AgentDiscountController::class);
        Route::get('fetch_tour_pkg/{id}','Agents\AgentDiscountController@fetch_tour_pkg');
        Route::post('get_custom_pkg_discount','Agents\AgentDiscountController@get_data');
        Route::resource('agent_commission',Agents\AgentCommissionController::class);
        Route::post('get_agent_commission','Agents\AgentCommissionController@get_data');
        Route::get('fetch_agent_group/{id}','Agents\AgentUmrahController@fetch_agent_group');
    });
    Route::prefix('Agent')->group(function (){
        Route::get('', function (){
            return view('crm.home');
        });
    });

});


