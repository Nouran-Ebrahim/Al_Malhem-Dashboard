<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Common\Http\Controllers\api\CommonController;
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

Route::get('/terms',  [CommonController::class, 'terms']);

Route::get('/about',  [CommonController::class, 'about']);


Route::get('/contactData',  [CommonController::class, 'contactData']);

Route::post('/contactUs',  [CommonController::class, 'contactUs']);
