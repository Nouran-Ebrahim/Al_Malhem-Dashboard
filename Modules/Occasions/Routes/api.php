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

// Route::middleware('auth:api')->get('/occasions', function (Request $request) {
//     return $request->user();
// });
Route::get('/occasionsCategory',  [\Modules\Occasions\Http\Controllers\api\OccasionsCategoriesController::class, 'index']);

Route::get('/occasions',  [\Modules\Occasions\Http\Controllers\api\OccasionsController::class, 'index']);
