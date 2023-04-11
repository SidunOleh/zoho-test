<?php

use App\Http\Controllers\ZohoFormController;
use App\Http\Controllers\ZohoOAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * get access/refresh token
 */
Route::get('/zoho/oauth/{code}', [ZohoOAuthController::class, 'getToken']);
/**
 * handle form
 */
Route::post('/zoho/form', [ZohoFormController::class, 'handle']);
