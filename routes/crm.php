<?php

use App\Http\Controllers\Crm\CrmController;
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
    Route::prefix('crm')->group(function () {
        Route::get('fetch_ticket/{ticket}', [CrmController::class, 'fetch_ticket']);
    });

});
