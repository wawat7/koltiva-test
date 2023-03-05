<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
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

Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->post('logout', 'logout');
});


Route::middleware('auth:sanctum')->controller(UserController::class)->group(function() {
    Route::get('/users', 'all');
    Route::get('/users/{id}', 'findOne');
    Route::post('/users', 'create');
    Route::put('/users/{id}', 'update');
    Route::delete('/users/{id}', 'delete');
});
