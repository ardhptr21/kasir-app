<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**----------------------------------------------
 * Page Routes
 * Base Route: /
 * Description: Routes for the all pages
 *
 *---------------------------------------------**/
Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/produk', 'produk')->name('produk');
    Route::get('/user', 'user')->name('user');
});

/**----------------------------------------------
 * Shop Routes
 * Base Route: /shop
 * Description: Routes for shop
 *
 *---------------------------------------------**/
Route::controller(ShopController::class)->prefix('/shop')->group(function () {
    Route::get('/', 'index')->name('shop.index');
    Route::put('/store', 'update')->name('shop.update');
});

/**----------------------------------------------
 * Shop Routes
 * Base Route: /category
 * Description: Routes for category
 *
 *---------------------------------------------**/
Route::controller(CategoryController::class)->prefix('/category')->group(function () {
    Route::get('/', 'index')->name('category.index');
    Route::post('/', 'store')->name('category.store');
    Route::delete('/{category}', 'remove')->name('category.remove');
});

/**----------------------------------------------
 * Shop Routes
 * Base Route: /users
 * Description: Routes for users
 *
 *---------------------------------------------**/
Route::resource('/users', UserController::class)->except(['create', 'edit']);
