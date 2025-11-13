<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\TransactionController;
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
        Route::resource('/user', UserController::class);
        Route::resource('/member', MemberController::class);
        Route::resource('/partner', PartnerController::class);
    });

    Route::resource('/partner', PartnerController::class);
    Route::resource('/merchant', MerchantController::class);

    Route::resource('/wallet', WalletController::class);

    Route::resource('/log-activity', LogActivityController::class);

    Route::resource('/transaction', TransactionController::class);

    Route::resource('/akun', AccountController::class);
    Route::post('/personal-information/{id}', [AccountController::class, 'personalInformation'])->name('personalInformation');

    Route::resource('/pengelola', PengelolaController::class);
});
