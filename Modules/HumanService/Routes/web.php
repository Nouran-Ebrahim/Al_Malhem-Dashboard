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


Route::prefix('admin')->group(function () {

    Route::get('service/activate/{id}', 'HumanServiceController@activate');
    Route::get('serviceType/activate/{id}', 'ServiceTypeController@activate');

    Route::post('deleteServicePhoto', 'HumanServiceController@deleteServicePhoto');

    Route::resource('service', 'HumanServiceController');
    Route::resource('serviceType', 'ServiceTypeController');
});