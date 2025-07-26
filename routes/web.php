<?php
 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
 
// --- Guest Routes ---
// Routes for users who are not logged in.
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerSave'])->name('register.save');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginAction'])->name('login.action');
});

// --- Authenticated Routes ---
// Routes for users who are logged in.
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Resourceful CRUD routes
    Route::resource('products', ProductController::class);
    Route::resource('tags', TagController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
});