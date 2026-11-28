<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\PublicationController;
use Illuminate\Support\Facades\Route;

Route::post('/connexion', [ApiAuthController::class, 'connecter']);

Route::apiResource('publications', PublicationController::class)
    ->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('publications', PublicationController::class)
        ->except(['index', 'show']);
});