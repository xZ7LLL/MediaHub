<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'accueil']);
Route::get('/a-propos', [PageController::class, 'aPropos'])->name('a-propos');

Route::get('/categories', [CategorieController::class, 'index'])->name('categories.index');

Route::get('/contenus/{tri?}', [ContenuController::class, 'index'])
    ->where('tri', 'recent|ancien|titre')
    ->name('contenus.index');

Route::resource('contenus', ContenuController::class)->except(['index']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [AdminController::class, 'index'])->name('dashboard');
});
Route::get('/', [PageController::class, 'accueil'])->name('accueil');
