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

// Route::prefix('scientificexcellence')->group(function () {
//     Route::get('/', 'ScientificExcellenceController@index');
// });
Route::prefix('admin')->group(function () {
    Route::get('superior/activate/{id}', 'ScientificExcellenceController@activate');
    Route::get('party/activate/{id}', 'PartyController@activate');
    Route::post('deletePartyPhoto', 'PartyController@deletePartyPhoto');

    Route::post('addParty', 'ScientificExcellenceController@addParty');
    Route::resource('party', 'PartyController');
    Route::resource('superior', 'ScientificExcellenceController');
});