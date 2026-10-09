<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->tenant;

        if (!$tenant) {
            return view('tenant.dashboard', ['activeInvoice' => null, 'tenant' => null]);
        }

        $activeInvoice = Invoice::where('tenant_id', $tenant->id)
            ->with(['payments', 'room'])
            ->latest()
            ->first();

        return view('tenant.dashboard', compact('tenant', 'activeInvoice'));
    }
}