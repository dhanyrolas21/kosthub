<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return redirect()->route('tenant.dashboard')->with('error', 'Data penghuni tidak ditemukan.');
        }

        $complaints = Complaint::where('tenant_id', $tenant->id)
            ->with('room')
            ->latest()
            ->get();

        return view('tenant.complaints.index', compact('complaints', 'tenant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tenant = Auth::user()->tenant;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('complaints', 'public');
        }

        Complaint::create([
            'tenant_id' => $tenant->id,
            'room_id' => $tenant->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Laporan kerusakan berhasil dikirim ke Pemilik Kost.');
    }
}