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
    Route::prefix('Hr')->group(function () {
        Route::resource('designation', Hr\DesignationController::class);
        Route::post('get_designation', 'Hr\DesignationController@get_data');
        Route::resource('department', Hr\DepartmentController::class);
        Route::post('get_department', 'Hr\DepartmentController@get_data');
        Route::resource('employee', Hr\EmployeeController::class);
        Route::post('get_employee', 'Hr\EmployeeController@get_data');
    });

});


