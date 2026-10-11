<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
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

        // Ambil tagihan aktif bulan/periode ini
        $currentInvoice = Invoice::where('tenant_id', $tenant->id)
            ->latest()
            ->first();

        // Ambil riwayat pembayaran
        $paymentHistory = Payment::whereHas('invoice', function ($query) use ($tenant) {
            $query->where('tenant_id', $tenant->id);
        })->with('invoice')->latest()->get();

        return view('tenant.dashboard', compact('tenant', 'currentInvoice', 'paymentHistory'));
    }

    // Method disesuaikan dengan route 'invoices.pay'
    public function pay(Request $request, $invoiceId)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);

        // Upload berkas bukti ke folder storage/app/public/proofs
        $filePath = $request->file('proof_image')->store('proofs', 'public');

        // Buat catatan payment baru
        Payment::create([
            'invoice_id' => $invoice->id,
            'proof_image' => $filePath,
            'status' => 'pending',
            'notes' => 'Menunggu verifikasi pemilik kost.',
        ]);

        return redirect()->back()->with('success', 'Bukti transfer berhasil diunggah! Menunggu verifikasi pemilik kost.');
    }
}