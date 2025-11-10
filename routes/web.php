<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('v_page.auth.login');
});

//auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['cekAuth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/pengguna',)->group(function () {
        Route::resource('/user', UserController::class, ['except' => ['show', 'destroy', 'update', 'edit', 'store', 'create']]);
        Route::resource('/member', MemberController::class, ['except' => ['show', 'destroy']]);
        Route::resource('/partner', PartnerController::class, ['except' => ['show', 'destroy']]);
    });

    Route::resource('/partner', PartnerController::class, ['except' => ['show', 'destroy']]);

    Route::resource('/wallet', WalletController::class, ['except' => ['show', 'destroy']]);

    Route::resource('/log-activity', LogActivityController::class, ['except' => ['show', 'destroy']]);
});
