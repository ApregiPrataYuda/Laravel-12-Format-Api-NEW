<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CqsJoints;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::get('Cqs-Joints', [CqsJoints::class, 'index'])->name('api.cqs.joints');

Route::middleware('auth:sanctum')->group(function () {
Route::get('Users-Data', [UsersController::class, 'index'])->name('api.users.data');
Route::post('Users-Data-Add', [UsersController::class, 'store'])->name('api.users.add');         
Route::get('Users-Data-Detail/{id}', [UsersController::class, 'show'])->name('api.users.show');
Route::put('Users-Data-Update/{id}', [UsersController::class, 'update'])->name('api.users.update');             
Route::delete('Users-Data-Delete/{id}', [UsersController::class, 'destroy'])->name('api.users.delete');   
});