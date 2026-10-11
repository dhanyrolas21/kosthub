<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function download(Payment $payment)
    {
        // Pastikan hanya pembayaran yang sudah lunas/disetujui yang bisa dicetak
        if (strtolower($payment->status) !== 'approved' && strtolower($payment->invoice?->status) !== 'paid') {
            return redirect()->back()->with('error', 'Kwitansi hanya tersedia untuk pembayaran yang sudah disetujui.');
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('payment'));
        
        return $pdf->download('Kwitansi-KostHub-' . $payment->id . '.pdf');
    }
}