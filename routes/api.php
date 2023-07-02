<?php

use App\Http\Controllers\AnimalTreatmentController;
use App\Http\Controllers\AnimalWeightController;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\AnimalCategoryController;
use App\Http\Controllers\AllFarmAnimalsController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ItemStockController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

