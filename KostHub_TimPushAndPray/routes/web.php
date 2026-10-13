<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\RoomController;
use App\Http\Controllers\Owner\TenantController;
use App\Http\Controllers\Owner\PaymentVerificationController;
use App\Http\Controllers\Owner\ComplaintController as OwnerComplaintController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Tenant\PaymentController;
use App\Http\Controllers\Tenant\ComplaintController as TenantComplaintController;
use App\Http\Controllers\ReceiptController;

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

        // Rute Laporan Kerusakan (Pemilik)
        Route::get('/complaints', [OwnerComplaintController::class, 'index'])->name('complaints.index');
        Route::patch('/complaints/{complaint}', [OwnerComplaintController::class, 'updateStatus'])->name('complaints.update');

        // Rute Persetujuan Checkout (Pemilik)
        Route::post('/tenants/{tenant}/approve-checkout', [TenantController::class, 'approveCheckout'])->name('tenants.approveCheckout');
    });

    // Group Rute Penghuni
    Route::middleware(['role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
        Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');
        
        // PERBAIKAN: Diubah dari 'store' menjadi 'pay'
        Route::post('/invoices/{invoice}/pay', [PaymentController::class, 'pay'])->name('invoices.pay');

        // Rute Laporan Kerusakan (Penghuni)
        Route::get('/complaints', [TenantComplaintController::class, 'index'])->name('complaints.index');
        Route::post('/complaints', [TenantComplaintController::class, 'store'])->name('complaints.store');

        // Rute Pengajuan Checkout (Penghuni)
        Route::post('/checkout', [TenantDashboardController::class, 'requestCheckout'])->name('checkout.request');
    });

    // Rute Unduh Kwitansi PDF (Dapat diakses Owner & Tenant)
    Route::get('/payments/{payment}/receipt', [ReceiptController::class, 'download'])->name('payments.receipt');
});

require __DIR__.'/auth.php';