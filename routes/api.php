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

use App\Http\Controllers\Api\Fpcontroller;
use App\Http\Controllers\Api\LicenseRenewalController;
use App\Http\Controllers\Api\LicenseStatusController;

Route::get('/fp', [Fpcontroller::class, 'index']);
Route::post('/receive', [Fpcontroller::class, 'receive']);

Route::post('/license-renewals', [LicenseRenewalController::class, 'store']);
Route::get('/license-status', [LicenseStatusController::class, 'show']);

