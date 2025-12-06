<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === МАРШРУТИ КЛІЄНТСЬКОЇ ЧАСТИНИ (PUBLIC) ===

// Головна сторінка та перегляд каталогу
Route::get('/', [ProductController::class, 'index'])->name('products.home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Сторінка акцій
Route::get('/offers', [ProductController::class, 'offers'])->name('products.offers');

// Маршрут для перегляду окремого товару
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Маршрут для збереження відгуків
Route::post('/products/{product}/reviews', [ProductController::class, 'storeReview'])
    ->name('products.reviews.store')
    ->middleware('auth');

// === МАРШРУТИ КОШИКА (CART) ===
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::get('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::patch('/update', [CartController::class, 'update'])->name('update');
    Route::delete('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Автентифікація
Auth::routes();


// === АДМІН МАРШРУТИ (ЗАХИЩЕНА ГРУПА) ===

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. ГОЛОВНА СТОРІНКА АДМІНКИ (Товари)
    Route::get('/', [ProductController::class, 'adminIndex'])->name('index'); 

    // 2. УПРАВЛІННЯ ТОВАРАМИ (CRUD Products)
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 3. УПРАВЛІННЯ КАТЕГОРІЯМИ (CRUD Categories)
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');