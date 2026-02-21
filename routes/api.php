<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('events', EventController::class);
    Route::get('/my-events', [EventController::class, 'myEvents']);
    
    Route::prefix('events/{event}')->group(function () {
        Route::post('/register', [RegistrationController::class, 'register']);
        Route::delete('/register', [RegistrationController::class, 'cancel']);
        Route::get('/registrations', [RegistrationController::class, 'eventRegistrations']);
        Route::post('/attendance', [RegistrationController::class, 'markAttendance']);
    });
    
    Route::get('/my-registrations', [RegistrationController::class, 'myRegistrations']);
});

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);
