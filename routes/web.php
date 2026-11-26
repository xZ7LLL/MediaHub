<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'accueil'])->name('accueil');
Route::get('/a-propos', [PageController::class, 'aPropos'])->name('a-propos');

Route::middleware('guest')->group(function () {
    Route::get('/inscription', [AuthController::class, 'create'])->name('inscription');
    Route::post('/inscription', [AuthController::class, 'store']);
    Route::get('/connexion', [AuthController::class, 'creerConnexion'])->name('connexion');
    Route::post('/connexion', [AuthController::class, 'connecter']);
});

Route::middleware('auth')->group(function () {
    Route::post('/deconnexion', [AuthController::class, 'deconnecter'])->name('deconnexion');

    Route::resource('contenus', ContenuController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['contenus' => 'publication']);
});

Route::resource('categories', CategorieController::class)
    ->except(['show'])
    ->parameters(['categories' => 'categorie']);

Route::get('/contenus/{tri?}', [ContenuController::class, 'index'])
    ->where('tri', 'recent|ancien|titre')
    ->name('contenus.index');

Route::resource('contenus', ContenuController::class)
    ->only(['show'])
    ->parameters(['contenus' => 'publication']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [AdminController::class, 'index'])->name('dashboard');
});