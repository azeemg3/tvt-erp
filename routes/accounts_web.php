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
    Route::prefix('Accounts')->group(function () {
        Route::resource('financial_year',FinancialYearController::class);
        Route::post('get_financial_year','FinancialYearController@get_data');
        Route::resource('root_accounts', Accounts\RootController::class);
        Route::post('get_root_accounts', 'Accounts\RootController@get_data');
        Route::resource('dashboard', Accounts\AccountDashboardController::class);
        Route::resource('head_accounts', Accounts\HeadAccountController::class);
        Route::post('get_head_accounts', 'Accounts\HeadAccountController@get_data');
        Route::resource('subhead_accounts', Accounts\SubHeadAccountController::class);
        Route::post('get_subhead_accounts', 'Accounts\SubHeadAccountController@get_data');
        Route::resource('trans_accounts', Accounts\TransAccountController::class);
        Route::post('get_trans_accounts', 'Accounts\TransAccountController@get_data');
        Route::prefix('vouchers')->group(function (){
            Route::resource('receipt_vouchers', Accounts\ReceiptVoucherController::class);
            Route::post('get_receipt_vouchers', 'Accounts\ReceiptVoucherController@get_data');
            Route::get('fetch_client_inv/{id}', 'Accounts\ReceiptVoucherController@fetch_client_inv');
            Route::get('fetch_inv_balance/{id}', 'Accounts\ReceiptVoucherController@fetch_inv_balance');
            Route::resource('payment_vouchers', Accounts\PaymentVoucherController::class);
            Route::post('get_payment_vouchers', 'Accounts\PaymentVoucherController@get_data');
            Route::resource('journal_vouchers', Accounts\JournalVoucherController::class);
            Route::post('get_journal_vouchers', 'Accounts\JournalVoucherController@get_data');
        });
        Route::get('ledger', 'Accounts\Reports\LedgerController@index');
        Route::prefix('reports')->group(function(){
            Route::post('get_ledger', 'Accounts\Reports\LedgerController@get_ledger');
            Route::resource('trail_balance', Accounts\Reports\TraialBalanceController::class);
            Route::resource('account_day_book', Accounts\Reports\AccountDayBookController::class);
            Route::get('view_account_day_book/{id}', 'Accounts\Reports\AccountDayBookController@view_account_day_book');
            Route::resource('balance_sheet', Accounts\Reports\BalanceSheetController::class);
            Route::resource('income_statement', Accounts\Reports\IncomeStatementController::class);
            Route::get('ledger_report', 'Accounts\Reports\LedgerController@index');
        });
        Route::resource('service_providors',Accounts\ServiceProvidorController::class);
        Route::post('get_service_providors','Accounts\ServiceProvidorController@get_data');
    });

});


