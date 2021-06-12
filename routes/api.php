<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\LogicController;

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
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::middleware(['auth:api'])->group(function () {
    Route::post('/duplicates', [LogicController::class,'createDuplicate']);
    Route::get('/duplicates', [LogicController::class,'getDuplicate']);
    Route::put('/duplicates/{id}', [LogicController::class,'updateDuplicate']);
    Route::delete('/duplicates/{id}', [LogicController::class,'deleteDuplicate']);
    Route::post('duplicate-counts', [LogicController::class, 'duplicateCount']);
});
