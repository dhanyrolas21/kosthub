<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('room_number', 'asc')->get();
        $totalRooms = $rooms->count();
        $occupiedRooms = $rooms->where('status', 'occupied')->count();
        $availableRooms = $rooms->where('status', 'available')->count();

        // Ambil pembayaran yang terhubung dengan invoice berkategori LUNAS (paid) bulan ini
        $monthlyPayments = Payment::whereHas('invoice', function ($query) {
                $query->where('status', 'paid');
            })
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->with(['invoice.tenant.user', 'invoice.room'])
            ->latest()
            ->get();

        // Hitung total pendapatan bulan ini
        $monthlyRevenue = $monthlyPayments->sum(fn($p) => $p->invoice?->amount ?? 0);

        return view('owner.dashboard', [
            'rooms' => $rooms,
            'totalRooms' => $totalRooms,
            'occupiedRooms' => $occupiedRooms,
            'availableRooms' => $availableRooms,
            'monthlyRevenue' => $monthlyRevenue,
            'paymentHistory' => $monthlyPayments,
        ]);
    }
}