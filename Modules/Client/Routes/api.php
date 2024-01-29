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

// Route::middleware('auth:api')->get('/client', function (Request $request) {
//     return $request->user();
// });


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'api'

], function ($router) {

    Route::post('login', 'ClientAuthController@login');
    Route::post('register', 'ClientAuthController@register');
    Route::post('verify', 'ClientAuthController@verifyOtp');
    Route::post('logout', 'ClientAuthController@logout');
    Route::post('refresh', 'ClientAuthController@refresh');
    Route::post('me', 'ClientAuthController@me');



    Route::post('forgetPassword', 'ClientAuthController@forgetPassword');
    Route::post('verifyForgetPassword', 'ClientAuthController@verifyForgetPassword');
    Route::post('newPassword', 'ClientAuthController@newPassword');
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'notification',
    'namespace' => 'api'

], function ($router) {

    Route::get('all', 'NotificationController@index');
    Route::post('read', 'NotificationController@readNotification');
    Route::get('unReadNotificationsCount', 'NotificationController@unReadNotificationsCount');
});
