<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        // Ambil semua data pembayaran beserta relasinya
        $pendingPayments = Payment::with(['invoice.tenant.user', 'invoice.room'])
            ->latest()
            ->get();

        return view('owner.payments.index', compact('pendingPayments'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string|max:255',
        ]);

        $payment = Payment::with('invoice')->findOrFail($id);

        DB::transaction(function () use ($request, $payment) {
            if ($request->action === 'approve') {
                // Update catatan pembayaran jika ada
                if (\Schema::hasColumn('payments', 'status')) {
                    $payment->update(['status' => 'approved', 'notes' => $request->notes]);
                } else {
                    $payment->update(['notes' => $request->notes]);
                }

                // Ubah status invoice menjadi PAID agar nominalnya masuk ke Pendapatan Dashboard Pemilik
                if ($payment->invoice) {
                    $payment->invoice->update([
                        'status' => 'paid',
                    ]);
                }
            } else {
                // Jika ditolak
                if (\Schema::hasColumn('payments', 'status')) {
                    $payment->update(['status' => 'rejected', 'notes' => $request->notes]);
                } else {
                    $payment->update(['notes' => $request->notes]);
                }

                if ($payment->invoice) {
                    $payment->invoice->update([
                        'status' => 'unpaid',
                    ]);
                }
            }
        });

        return redirect()->route('owner.payments.index')->with('success', $request->action === 'approve' ? 'Pembayaran berhasil disetujui! Status tagihan menjadi LUNAS dan pendapatan masuk ke dashboard.' : 'Pembayaran telah ditolak.');
    }
}