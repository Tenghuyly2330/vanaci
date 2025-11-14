<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ItemController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ExploreController;
use App\Http\Controllers\Admin\ItemBackendController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
Route::get('/item', [ItemController::class, 'index'])->name('item');
Route::get('/item/{slug}', [ItemController::class, 'show'])->name('item.show');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('type', TypeController::class)->except(['destroy', 'show']);
    Route::get('type/delete/{type}', [TypeController::class, 'delete'])->name('type.delete');

    Route::resource('category', CategoryController::class)->except(['destroy', 'show']);
    Route::get('category/delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');

    Route::resource('item_backend', ItemBackendController::class)->except(['destroy', 'show']);
    Route::get('item_backend/delete/{item_backend}', [ItemBackendController::class, 'delete'])->name('item_backend.delete');

});

require __DIR__ . '/auth.php';
