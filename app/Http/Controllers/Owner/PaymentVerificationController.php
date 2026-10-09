<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $pendingPayments = Payment::with(['invoice.tenant.user', 'invoice.room'])
            ->whereNull('verified_at')
            ->latest()
            ->get();

        return view('owner.payments.index', compact('pendingPayments'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string',
        ]);

        if ($request->action === 'approve') {
            $payment->update([
                'verified_at' => now(),
                'verified_by' => auth()->id(),
                'notes' => $request->notes,
            ]);
            $payment->invoice->update(['status' => 'paid']);
        } else {
            $payment->update([
                'verified_at' => now(),
                'verified_by' => auth()->id(),
                'notes' => $request->notes,
            ]);
            $payment->invoice->update(['status' => 'unpaid']);
        }

        return back()->with('success', 'Status verifikasi pembayaran berhasil diperbarui.');
    }
}