<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Invoice;
use App\Models\Tenant;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        
        $currentMonthEarnings = Invoice::where('period_month', now()->month)
            ->where('period_year', now()->year)
            ->where('status', 'paid')
            ->sum('amount');

        $unpaidInvoices = Invoice::with(['tenant.user', 'room'])
            ->whereIn('status', ['unpaid', 'pending'])
            ->latest()
            ->take(5)
            ->get();

        $rooms = Room::all();

        return view('owner.dashboard', compact(
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'currentMonthEarnings',
            'unpaidInvoices',
            'rooms'
        ));
    }
}