<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//get user name
Route::get('get-company-user-name', [ApiController::class, 'getCompanyUserName']);
//get catlog wrc api
Route::get('get-wrc-data-basedon-userid-brandid', [ApiController::class, 'getCatlogWrc']);
// get brand based on user id
Route::get('get-brands/{userId}', [ApiController::class, 'getBrands']);

