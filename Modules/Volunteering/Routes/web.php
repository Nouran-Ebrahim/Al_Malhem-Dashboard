<?php

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
    Route::get('volunteering/activate/{id}', 'VolunteeringController@activate');
    Route::get('volunteeringTypes/activate/{id}', 'VolunteeringTypesController@activate');
    Route::get('volunteering/getClientData/{id}', 'VolunteeringController@getClientData');
    Route::resource('volunteering', 'VolunteeringController');
    Route::resource('volunteeringTypes', 'VolunteeringTypesController');
    Route::post('deleteVolunteeringRequestPhoto', 'VolunteeringRequestController@deleteVolunteeringRequestPhoto');
    Route::get('volunteeringRequest/activate/{id}', 'VolunteeringRequestController@activate');

    Route::resource('volunteeringRequest', 'VolunteeringRequestController');

});
