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

// Route::prefix('calender')->group(function() {
//     Route::get('/', 'CalenderController@index');
// });
Route::prefix('admin')->group(function () {

    Route::get('calender/activate/{id}', 'CalenderController@activate');

    Route::post('deleteCalenderPhoto', 'CalenderController@deleteCalenderPhoto');
    Route::resource('calender', 'CalenderController');
 
  
});