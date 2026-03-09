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
    Route::prefix('cms')->group(function () {
        Route::resource('/', Cms\CmsController::class);
        Route::resource('quarantine', Cms\QuarantineController::class);
        Route::post('get_quarantine', 'Cms\QuarantineController@get_data');
        Route::prefix('umrah')->group(function(){
            Route::resource('customize_packages', Cms\Umrah\CustomizeController::class);
            Route::post('get_customize_packages', 'Cms\Umrah\CustomizeController@get_data');
        });
        Route::prefix('tours')->group(function (){
            Route::resource('tour', Tours\IntTourController::class);
            Route::post('get_tours', 'Tours\IntTourController@get_data');
            Route::get('app_tour/{id}', 'Tours\IntTourController@apporve');
        });
    });

});


