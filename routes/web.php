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
//Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('notify','LeadController@notify');
Auth::routes();
Route::get('/', function () {
    return Redirect::to('home');
//    return view('home');
});
Route::get('noti',function (){
   return view('noti');
});
Route::get('get_agent_umrah_notification', function () {
    event(new App\Events\NotificationEvent('Some Agent Create Umrah Trip'));
});
//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');
   
Route::get('/locale/update/{user_prefer_language}', function($locale){
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
Route::group(['middleware' => ['auth']], function() {
    Route::prefix('lms')->group(function (){
       Route::resource('lead', LeadController::class);
       Route::get('pending_leads', 'LeadController@pending_leads');
       Route::get('my_leads', 'LeadController@my_leads');
       Route::post('get_my_leads', 'LeadController@get_my_leads');
       Route::get('all_leads', 'LeadController@all_leads');
       Route::post('get_all_leads', 'LeadController@get_all_leads');
       Route::post('lead_conversation', 'LeadController@lead_conversation');
       Route::get('get_lead_conversation/{id}', 'LeadController@get_lead_conversation');
       Route::get('lead_alerts', 'LeadController@lead_alerts');
       //@lead sales
        Route::resource('sale_invoice', LeadSale\SaleInvoiceController::class);
        Route::resource('lead_ticket', LeadSale\TicketController::class);
        Route::post('get_lead_ticket_inv', 'LeadSale\TicketController@index');
        Route::get('get_lead_ticket_invDetails/{id}', 'LeadSale\TicketController@get_lead_ticket_invDetails');
        //@hotel sale
        Route::resource('lead_hotel', LeadSale\HotelController::class);
        Route::post('get_lead_hotel_inv', 'LeadSale\HotelController@index');
        Route::get('get_lead_hotel_invDetails/{id}', 'LeadSale\HotelController@get_lead_hotel_invDetails');
        //@visa sale
        Route::resource('lead_visa', LeadSale\VisaController::class);
        Route::post('get_lead_visa_inv', 'LeadSale\VisaController@index');
        Route::get('get_lead_visa_invDetails/{id}', 'LeadSale\VisaController@get_lead_visa_invDetails');
        //@transport sale
        Route::resource('lead_transport', LeadSale\TransportController::class);
        Route::post('get_lead_transport_inv', 'LeadSale\TransportController@index');
        Route::get('get_lead_transport_invDetails/{id}', 'LeadSale\TransportController@get_lead_transport_invDetails');
        //@other sale
        Route::resource('lead_other', LeadSale\OtherController::class);
        Route::post('get_lead_other_inv', 'LeadSale\OtherController@index');
        Route::get('get_lead_other_invDetails/{id}', 'LeadSale\OtherController@get_lead_other_invDetails');
        //@tour sale
        Route::post('tour_pax', 'LeadSale\TourController@tour_pax');
        Route::post('get_lead_tour', 'LeadSale\TourController@index');
        Route::post('tour_ticket_store', 'LeadSale\TourController@ticket_store');
        Route::post('tour_hotel_store', 'LeadSale\TourController@hotel_store');
        //tour visa
        Route::post('tour_visa_store', 'LeadSale\TourController@visa_store');
        //tour transport
        Route::post('tour_transport_store', 'LeadSale\TourController@transport_store');
        Route::post('tour_other_store', 'LeadSale\TourController@other_store');
        Route::resource('refund', LeadSale\RefundController::class);
        Route::post('get_refunds', 'LeadSale\RefundController@index');
        //receipt
        Route::resource('receipt', LeadSale\ReceiptController::class);
        Route::post('get_receipts', 'LeadSale\ReceiptController@index');
        //create ledger lead request
        Route::post('lead_ledger','LeadController@lead_ledger');
        Route::get('get_lead_details/{id}','LeadController@get_lead_details');
        Route::resource('client_doc', LeadSale\AttDocController::class);
        Route::post('get_client_doc', 'LeadSale\AttDocController@index');
        Route::resource('lead_pcr_test',LeadSale\PcrController::class);
        Route::post('get_pcr_invoice','LeadSale\PcrController@index');
        Route::get('get_lead_pcr_invDetails/{id}','LeadSale\PcrController@get_lead_pcr_invDetails');
    });
    //settings
    Route::resource('categories', CategoriesController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::post('get_currencies', 'CurrencyController@get_data');
    Route::get('currency_api/{symbol?}','CurrencyController@get_apicurrency');
    Route::get('currency_history','CurrencyController@currency_history');
    Route::post('get_currency_history','CurrencyController@get_currency_history');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/logout', function(){
        Auth::logout();
        return Redirect::to('login');
    });
    Route::resource('company_setup', CompanyController::class);
    Route::resource('branches', BranchesController::class);
    Route::resource('continents', ContinentController::class);
    Route::post('get_continents', 'ContinentController@get_data');
    Route::resource('countries', CountryController::class);
    Route::post('get_countries', 'CountryController@get_data');
    Route::resource('province', ProvinceController::class);
    Route::post('get_province', 'ProvinceController@get_data');
    Route::resource('division',DivisionController::class);
    Route::post('get_division','DivisionController@get_data');
    Route::resource('district', DistrictController::class);
    Route::post('get_district', 'DistrictController@get_data');
    Route::resource('cities', CityController::class);
    Route::get('get_cities', 'CityController@get_data');
    Route::post('save_cities_excel', 'CityController@save_cities_excel');
    Route::resource('areas', AreaController::class);
    Route::get('get_areas', 'AreaController@get_data');
    Route::post('save_areas_excel', 'AreaController@save_areas_excel');
    Route::resource('mosques',MosqueController::class);
    Route::get('get_mosques','MosqueController@get_data');
    Route::post('save_mosque_excel','MosqueController@save_mosque_excel');
    //appication setup
    Route::prefix('Application_Setup')->group(function () {
        Route::prefix('Rate_Setup')->group(function () {
                Route::resource('visa_rate', ApplicationSetup\VisaRateController::class);
                Route::post('get_visa_rate', 'ApplicationSetup\VisaRateController@get_data');
                Route::get('approve_visa_rate/{id}', 'ApplicationSetup\VisaRateController@approve_visa_rate');
                Route::resource('hotel_rate', ApplicationSetup\HotelRateController::class);
                Route::post('get_hotel_rates', 'ApplicationSetup\HotelRateController@get_data');
                Route::get('approve_hotel_rate/{id}', 'ApplicationSetup\HotelRateController@approve_hotel_rate');
                Route::resource('transport_rate', ApplicationSetup\TransportRateController::class);
                Route::get('approve_transport_rate/{id}', 'ApplicationSetup\TransportRateController@approve_transport_rate');
                Route::post('get_transport_rates', 'ApplicationSetup\TransportRateController@get_data');
                Route::resource('ziarat_rate', ApplicationSetup\ZiaratRateController::class);
                Route::resource('ground_handling_rate', ApplicationSetup\GroundHandleRateController::class);
                Route::post('get_ground_handling_rate', 'ApplicationSetup\GroundHandleRateController@get_data');

        });
        Route::resource('hotel', ApplicationSetup\HotelController::class);
        Route::resource('room_types', ApplicationSetup\HotelRoomType::class);
        Route::post('get_room_types', 'ApplicationSetup\HotelRoomType@get_data');
        Route::post('get_hotels', 'ApplicationSetup\HotelController@get_data');
        Route::resource('ticket_source', ApplicationSetup\TicketSourceController::class);
        Route::post('get_ticket_source', 'ApplicationSetup\TicketSourceController@get_data');
        Route::resource('airlines', ApplicationSetup\AirlineController::class);
        Route::post('get_airlines', 'ApplicationSetup\AirlineController@get_data');
        Route::prefix('user_management')->group(function (){
            Route::resource('roles', RoleController::class);
            Route::post('store_menu', 'RoleController@store_menu');
            Route::post('get_menu', 'RoleController@get_menu');
            Route::resource('users', UserController::class);
            Route::resource('permission', PermissionController::class);
            Route::post('get_permission', 'PermissionController@get_data');
            Route::get('get_role_permission/{id}', 'PermissionController@get_role_permission');
        });

    });

    //Fetch Routes all common and basics result call
    Route::get('fetch_cities', 'CityController@fetch_cities');
    Route::prefix('statistics')->group(function (){
        Route::resource('statistic', StatisticsController::class);
        Route::get('admin_statistic', 'StatisticsController@admin_statistic');
        Route::get('subadmin_statistic', 'StatisticsController@subadmin_statistic');
        Route::get('agent_statistic', 'StatisticsController@agent_statistic');
    });
    //booking confirmation
    Route::prefix('BookingConfirmation')->group(function (){
       Route::resource('hotel_confirimation', HotelConfirmationController::class);
       Route::post('get_hotel_confirimation', 'HotelConfirmationController@get_data');
       Route::resource('transport_confirimation', TransportConfirmationController::class);
       Route::post('get_transport_confirimation', 'TransportConfirmationController@get_data');
    });
    Route::get('menu_notification','HomeController@menu_notification');
    Route::get('seen_notification/{tbl_name}','HomeController@seen_notification');
});


