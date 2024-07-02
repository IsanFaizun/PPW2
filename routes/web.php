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

Route::get('/dashboard', [BukuController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('admin')->group(function () {
    // Create
    Route::get('/dashboard/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/dashboard', [BukuController::class, 'store'])->name('buku.store');
    // Delete
    Route::post('/dashboard/destroy/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
    // Update
    Route::get('/dashboard/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
    Route::post('/dashboard/upadate/{id}', [BukuController::class, 'update'])->name('buku.update');
});
// Search
Route::get('/dashboard/search', [BukuController::class, 'search'])->name('buku.search');
// Delete galeri
Route::get('/gallery/delete/{id}', [BukuController::class, 'deleteGallery'])->name('buku.deleteGallery');