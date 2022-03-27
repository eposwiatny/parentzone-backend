<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;

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


Route::get('cars', [CarsController::class, 'index']);
Route::get('cars/{id}', [CarsController::class, 'view']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
