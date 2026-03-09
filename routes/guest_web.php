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
Route::group(['middleware' => ['auth']], function() {
    Route::prefix('guest')->group(function () {
        Route::resource('/', Guest\GuestController::class);
        Route::resource('/guest_users', Guest\GuestUserController::class);
        Route::post('get_guest_users', 'Guest\GuestUserController@get_data');
    });
});


