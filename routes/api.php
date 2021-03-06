<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\CodeResource;
use App\Code;

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

Route::middleware(['auth:sanctum'])->prefix('business')->group(function () {
    Route::get('/code/{code}', 'ClaimController@show');
    Route::post('/code/{code}', 'ClaimController@store');
});

Route::prefix('claim')->group(function () {
    Route::get('/code/{code}', 'ApiClaimController@show');
    Route::post('/code/{code}', 'ApiClaimController@store');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
