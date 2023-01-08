<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products', ProductController::class);
Route::resource('units', UnitController::class);
Route::resource('inventories', InventoryController::class);
Route::resource('images', ImageController::class);
Route::resource('users', UserController::class);
