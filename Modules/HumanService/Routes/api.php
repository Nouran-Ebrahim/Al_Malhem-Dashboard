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



Route::get('/serviceType',  [\Modules\HumanService\Http\Controllers\api\ServiceTypeController::class, 'index']);
Route::get('/service',  [\Modules\HumanService\Http\Controllers\api\HumanServiceController::class, 'index']);
Route::post('/service/store', [\Modules\HumanService\Http\Controllers\api\HumanServiceController::class, 'store']);
