<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function store(Request $request, Invoice $invoice)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        Payment::create([
            'invoice_id' => $invoice->id,
            'proof_image' => $path,
            'paid_at' => now(),
        ]);

        $invoice->update(['status' => 'pending']);

        return back()->with('success', 'Bukti transfer berhasil diunggah. Menunggu verifikasi pemilik.');
    }
}