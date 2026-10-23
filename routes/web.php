<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CustomerRoomController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\FloorController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Customer pages: admins can access these too.
Route::middleware(['auth', 'role:customer,admin'])
    ->prefix('rooms')
    ->name('customer.rooms.')
    ->group(function () {
        Route::get('/', [CustomerRoomController::class, 'index'])
            ->name('index');
        Route::get('/{room}', [CustomerRoomController::class, 'show'])
            ->name('show');
    });

Route::middleware(['auth', 'role:customer,admin'])
    ->prefix('my-bookings')
    ->name('customer.bookings.')
    ->group(function () {
        Route::get('/', [CustomerBookingController::class, 'index'])
            ->name('index');
        Route::get('/create', [CustomerBookingController::class, 'create'])
            ->name('create');
        Route::post('/', [CustomerBookingController::class, 'store'])
            ->name('store');
        Route::get('/{booking}', [CustomerBookingController::class, 'show'])
            ->name('show');
        Route::patch('/{booking}/cancel', [CustomerBookingController::class, 'cancel'])
            ->name('cancel');
    });

// Admin pages.
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)
            ->name('dashboard');

        Route::resource('rooms', RoomController::class);
        Route::resource('bookings', BookingController::class);
        Route::resource('hotels', HotelController::class);
        Route::resource('floors', FloorController::class);

        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])
            ->name('users.role');
    });
