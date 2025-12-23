<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DashboardController as ApiDashboard;

/*
|--------------------------------------------------------------------------
| API Routes - Sultans Coffee
|--------------------------------------------------------------------------
*/

// =====================
// AUTH (ANDROID)
// =====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// =====================
// MENU (PUBLIC - TANPA LOGIN)
// =====================
Route::get('/menus', [MenuController::class, 'index']);

// =====================
// PROTECTED API (SANCTUM)
// =====================
Route::middleware('auth:sanctum')->group(function () {

    // =====================
    // USER PROFILE
    // =====================
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // =====================
    // CUSTOMER - CART
    // =====================
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'store']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);

    // =====================
    // CUSTOMER - ORDER
    // =====================
    Route::get('/orders', [OrderController::class, 'index']);   // history
    Route::post('/orders', [OrderController::class, 'store']); // checkout

    // =================================================
    // ADMIN API (KHUSUS HP ADMIN)
    // =================================================
    Route::prefix('admin')->group(function () {

        // =====================
        // ORDER MANAGEMENT
        // =====================
        Route::get('/orders', [OrderController::class, 'allOrders']);
        Route::post('/orders/status', [OrderController::class, 'updateStatusApi']);

        // =====================
        // MENU MANAGEMENT
        // =====================
        Route::post('/menus', [MenuController::class, 'storeApi']);      // tambah menu
        Route::delete('/menus/{id}', [MenuController::class, 'destroyApi']); // hapus menu

        // =====================
        // DASHBOARD STATISTIK
        // =====================
        Route::get('/dashboard', [ApiDashboard::class, 'index']);
    });
});
