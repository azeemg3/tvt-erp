<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Reports Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::prefix('reports')->group(function (){
        Route::prefix('lead_reports')->group(function (){
            Route::get('customer_lead_reports','Reports\LeadReports\CustomerLeadReportsController@customer_lead_reports');
            Route::post('customer_report','Reports\LeadReports\CustomerLeadReportsController@print_customer_report');
        });
        Route::prefix('umrah')->group(function (){
           Route::resource('arrival_report',Reports\Umrah\ArrivalReportController::class);
           Route::post('get_arrival_report','Reports\Umrah\ArrivalReportController@get_data');
            Route::resource('departure_report',Reports\Umrah\DepartureReportController::class);
            Route::post('get_departure_report','Reports\Umrah\DepartureReportController@get_data');
            Route::resource('checkin_report',Reports\Umrah\CheckinReportController::class);
            Route::post('get_checkin_report','Reports\Umrah\CheckinReportController@get_data');
            Route::resource('checkout_report',Reports\Umrah\CheckoutReportController::class);
            Route::post('get_checkout_report','Reports\Umrah\CheckoutReportController@get_data');
        });
        Route::prefix('sale')->group(function (){
            Route::resource('simple_sale_register', Reports\Sale\SimpleSaleRegisterController::class);
            Route::post('get_simple_sale_register', 'Reports\Sale\SimpleSaleRegisterController@get_data');
            Route::resource('bsp_sale_report', Reports\Sale\BspSaleReportController::class);
            Route::post('get_bsp_sale_report', 'Reports\Sale\BspSaleReportController@get_data');
            Route::resource('pending_invoice_report', Reports\Sale\PendingInvoiceReportController::class);
            Route::post('get_pending_invoice_report', 'Reports\Sale\PendingInvoiceReportController@get_data');
            Route::resource('clearance_invoice_report', Reports\Sale\ClearanceInvoiceReportController::class);
            Route::post('get_clearance_invoice_report', 'Reports\Sale\ClearanceInvoiceReportController@get_data');
        });
    });
});


