<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/meeting', function (Request $request) {
//     return $request->user();
// });
Route::group([

    'middleware' => 'api',
    'prefix' => 'meeting',
    'namespace' => 'api'

], function ($router) {

    Route::post('store', 'MeetingController@store');
    Route::get('index', 'MeetingController@index');
    Route::post('deleteMeetingPhoto', 'MeetingController@deleteMeetingsPhotos');
    Route::post('activate', 'MeetingController@activate');
    Route::post('/update', 'MeetingController@update');
 });
