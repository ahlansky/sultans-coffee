<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\OutletController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sultans Coffee
|--------------------------------------------------------------------------
*/

// =====================
// LANDING PAGE
// =====================
Route::get('/', function () {
    return view('welcome');
});

// =====================
// AUTH ADMIN (LOGIN & LOGOUT)
// =====================
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AdminAuthController::class, 'login']);
Route::post('/logout', [AdminAuthController::class, 'logout'])
    ->name('logout');

// =====================
// ADMIN PANEL (PROTECTED)
// =====================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // DASHBOARD
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // UPDATE STATUS ORDER
        Route::patch(
            '/orders/{order}/status',
            [DashboardController::class, 'updateStatus']
        )->name('orders.updateStatus');

        // CRUD MENU
        Route::resource('menus', MenuController::class);

        // CRUD OUTLET
        Route::resource('outlets', OutletController::class);

        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    });
