<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/detail/{id}/rate', [BukuController::class, 'rate'])->name('buku.rate');
    Route::get('/favorite', [BukuController::class, 'favorite'])->name('buku.favorite');
    Route::post('/detail/{id}/favorite', [BukuController::class, 'addToFavorite'])->name('buku.addToFavorite');
    Route::delete('/favorite/{id}', [BukuController::class, 'removeFromFavorite'])->name('buku.removeFromFavorite');
});

require __DIR__.'/auth.php';

Route::get('/list', [BukuController::class, 'list'])->name('buku.list');
Route::get('/detail/{id}', [BukuController::class, 'detail'])->name('buku.detail');


Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [BukuController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
    // Create
    Route::get('/dashboard/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/dashboard', [BukuController::class, 'store'])->name('buku.store');
    // Delete
    Route::post('/dashboard/destroy/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
    // Update
    Route::get('/dashboard/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
    Route::post('/dashboard/upadate/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::get('/gallery/delete/{id}', [BukuController::class, 'deleteGallery'])->name('buku.deleteGallery');
});

// Search
Route::get('/dashboard/search', [BukuController::class, 'search'])->name('buku.search');
