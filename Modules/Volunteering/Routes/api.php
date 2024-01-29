<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/volunteering', function (Request $request) {
//     return $request->user();
// });
Route::get('/volunteeringTypes',  [\Modules\Volunteering\Http\Controllers\api\VolunteeringTypesController::class, 'index']);

Route::group([

    'middleware' => 'api',
    'prefix' => 'volunteering',
    'namespace' => 'api'

], function ($router) {

    Route::post('store', 'VolunteeringController@store');
    Route::get('index', 'VolunteeringController@index');
    Route::get('VolunteeringRequest/index', 'VolunteeringRequestController@index');
    Route::post('VolunteeringRequest/join', 'VolunteeringRequestController@join');

 });
