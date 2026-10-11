<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        // Hanya ambil data pembayaran yang berstatus PENDING
        $pendingPayments = Payment::query()
            ->when(Schema::hasColumn('payments', 'status'), function ($query) {
                $query->where('status', 'pending');
            }, function ($query) {
                // Fallback jika kolom status di payments tidak ada, filter dari invoice unpaid
                $query->whereHas('invoice', function ($q) {
                    $q->where('status', 'unpaid');
                });
            })
            ->with(['invoice.tenant.user', 'invoice.room'])
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
                // Update status payment menjadi approved
                if (Schema::hasColumn('payments', 'status')) {
                    $payment->update([
                        'status' => 'approved', 
                        'notes' => $request->notes
                    ]);
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
                if (Schema::hasColumn('payments', 'status')) {
                    $payment->update([
                        'status' => 'rejected', 
                        'notes' => $request->notes
                    ]);
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

        return redirect()->route('owner.payments.index')->with(
            'success', 
            $request->action === 'approve' 
                ? 'Pembayaran berhasil disetujui! Status tagihan menjadi LUNAS dan pendapatan masuk ke dashboard.' 
                : 'Pembayaran telah ditolak.'
        );
    }
}