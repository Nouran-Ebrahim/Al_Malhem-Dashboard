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

    Route::get('news/activate/{id}', 'NewsController@activate');
    Route::get('newsCategory/activate/{id}', 'NewsCategoriesController@activate');
    
    Route::post('deleteNewsPhoto', 'NewsController@deleteNewsPhoto');

    Route::resource('news', 'NewsController');
    Route::resource('newsCategory', 'NewsCategoriesController');
  
});