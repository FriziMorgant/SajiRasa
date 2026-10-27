<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — SajiRasa (Dapur Rumahan)
|--------------------------------------------------------------------------
*/

// Katalog Resep Utama & Filter (Public)
Route::get('/', [RecipeController::class, 'index'])->name('recipes.index');

// Route Khusus Pengguna Terautentikasi (Harus Login)
Route::middleware('auth')->group(function () {
    // Kelola Resep Saya
    Route::get('/resep-saya', [RecipeController::class, 'myRecipes'])->name('recipes.my-recipes');

    // Tambah Resep Baru
    Route::get('/resep/tambah', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/resep', [RecipeController::class, 'store'])->name('recipes.store');

    // Manajemen Resep (Edit & Delete)
    Route::get('/resep/{id}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/resep/{id}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/resep/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    // Fitur Manajemen Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/info', [ProfileController::class, 'updateInfo'])->name('profile.update-info');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Fitur Favorit
    Route::get('/favorit', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/resep/{id}/favorit', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Fitur Ulasan / Komentar
    Route::post('/resep/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route Detail Resep (Public)
Route::get('/resep/{id}', [RecipeController::class, 'show'])->name('recipes.show');

// Autentikasi Tamu / Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
