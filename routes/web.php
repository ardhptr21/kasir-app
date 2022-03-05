<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**----------------------------------------------
 * Auth Routes
 * Base Route: /auth
 * Description: Routes for handle authentication
 *
 *---------------------------------------------**/
Route::controller(AuthController::class)->prefix('/auth')->middleware('guest')->group(function () {
    Route::get('/login', 'login')->name('auth.login');
    Route::post('/login', 'logged')->name('auth.logged');
    Route::get('/logout', 'logout')->name('auth.logout')->withoutMiddleware('guest')->middleware('auth');
});

/**----------------------------------------------
 * Page Routes
 * Base Route: /
 * Description: Routes for the all pages
 *
 *---------------------------------------------**/
Route::controller(PagesController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/user', 'user')->name('user');
});

/**----------------------------------------------
 * Service Routes
 * Base Route: /services
 * Description: Routes for the service
 *
 *---------------------------------------------**/
Route::resource('/services', ServiceController::class)->middleware(['auth', 'can:admin'])->except(['show', 'create']);

/**----------------------------------------------
 * Shop Routes
 * Base Route: /shop
 * Description: Routes for shop
 *
 *---------------------------------------------**/
Route::controller(ShopController::class)->middleware(['auth', 'can:owner'])->prefix('/shop')->group(function () {
    Route::get('/', 'index')->name('shop.index');
    Route::put('/store', 'update')->name('shop.update');
});

/**----------------------------------------------
 * Category Routes
 * Base Route: /category
 * Description: Routes for category
 *
 *---------------------------------------------**/
Route::controller(CategoryController::class)->middleware(['auth', 'can:admin'])->prefix('/category')->group(function () {
    Route::get('/', 'index')->name('category.index');
    Route::post('/', 'store')->name('category.store');
    Route::delete('/{category}', 'remove')->name('category.remove');
});

/**----------------------------------------------
 * User Routes
 * Base Route: /users
 * Description: Routes for users
 *
 *---------------------------------------------**/
Route::resource('/users', UserController::class)->middleware('auth')->except(['create', 'edit']);
Route::put('/users/{user}/change-password', [UserController::class, 'changePassword'])->middleware('auth')->name('users.change-password');

/**----------------------------------------------
 * Member Routes
 * Base Route: /members
 * Description: Routes for members
 *
 *---------------------------------------------**/
Route::resource('/members', MemberController::class)->middleware(['auth', 'can:admin'])->except(['create', 'edit']);
