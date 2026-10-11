<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return view('tenant.dashboard', [
                'tenant' => null,
                'currentInvoice' => null,
                'paymentHistory' => collect()
            ]);
        }

        // Tagihan terbaru
        $currentInvoice = Invoice::where('tenant_id', $tenant->id)
            ->latest()
            ->first();

        // Riwayat pembayaran
        $paymentHistory = Payment::whereHas('invoice', function ($query) use ($tenant) {
            $query->where('tenant_id', $tenant->id);
        })->with('invoice')->latest()->get();

        return view('tenant.dashboard', compact('tenant', 'currentInvoice', 'paymentHistory'));
    }

    public function requestCheckout(Request $request)
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return redirect()->back()->with('error', 'Data penghuni tidak ditemukan.');
        }

        $tenant->update([
            'checkout_status' => 'pending',
            'checkout_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhenti sewa berhasil dikirim ke Pemilik Kost.');
    }
}