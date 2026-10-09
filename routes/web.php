<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\RoomController;
use App\Http\Controllers\Owner\TenantController;
use App\Http\Controllers\Owner\PaymentVerificationController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Tenant\PaymentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Redirection otomatis berdasarkan role user
    Route::get('/dashboard', function () {
        if (auth()->user()->isOwner()) {
            return redirect()->route('owner.dashboard');
        }
        return redirect()->route('tenant.dashboard');
    })->name('dashboard');

    // Rute Profile bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Group Rute Pemilik
    Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('rooms', RoomController::class);
        Route::resource('tenants', TenantController::class);
        Route::get('/payments', [PaymentVerificationController::class, 'index'])->name('payments.index');
        Route::post('/payments/{payment}/verify', [PaymentVerificationController::class, 'verify'])->name('payments.verify');
    });

    // Group Rute Penghuni
    Route::middleware(['role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
        Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');
        Route::post('/invoices/{invoice}/pay', [PaymentController::class, 'store'])->name('invoices.pay');
    });
});

require __DIR__.'/auth.php';