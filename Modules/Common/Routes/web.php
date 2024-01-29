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

// Route::prefix('common')->group(function() {
//     Route::get('/', 'CommonController@index');
// });

Route::prefix('admin')->group(function () {

    Route::get('/setting', 'CommonController@setting')->name('setting.index');
    Route::post('/setting', 'CommonController@savesetting');

    Route::get('/logs', 'CommonController@logs')->name('logs.index');

    Route::resource('subjects','SubjectController');

    Route::resource('holiday_types', 'HolidayTypesController');
    Route::resource('teacher_levels', 'TeacherLevelsController');
    Route::resource('news', 'NewsController');
    Route::resource('qrcode', 'QrCodeController');


    Route::get('vacation/{id}/sendNotification', 'VacationController@sendNotification');
    Route::resource('vacation', 'VacationController');
    Route::resource('violations', 'ViolationsController');

});
