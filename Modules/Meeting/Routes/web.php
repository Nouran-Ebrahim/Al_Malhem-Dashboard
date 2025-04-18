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

Route::prefix('admin')->group(function() {

    Route::get('meeting/activate/{id}', 'MeetingController@activate');
    Route::post('deleteMeetingPhoto', 'MeetingController@deleteMeetingsPhotos');
    Route::resource('meeting', "MeetingController");
});
