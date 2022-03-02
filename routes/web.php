<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ShopController;
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
    Route::get('/kategori', 'kategori')->name('kategori');
    Route::get('/user', 'user')->name('user');
    Route::get('/users', 'users')->name('users');
});

/**----------------------------------------------
 * Shop Routes
 * Base Route: /shop
 * Description: Routes for shop
 *
 *---------------------------------------------**/
Route::controller(ShopController::class)->prefix('/shop')->group(function () {
    Route::get('/', 'index')->name('shop:index');
    Route::put('/store', 'update')->name('shop:update');
});
