<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

/**----------------------------------------------
 * Page Routes
 * Base Route: /
 * Description: Routes for the all pages
 *
 *---------------------------------------------**/
Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/toko', 'toko')->name('toko');
    Route::get('/produk', 'produk')->name('produk');
    Route::get('/kategori', 'kategori')->name('kategori');
    Route::get('/user', 'user')->name('user');
});
