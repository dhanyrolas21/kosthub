<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with(['tenant.user', 'room'])
            ->latest()
            ->get();

        return view('owner.complaints.index', compact('complaints'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'owner_notes' => 'nullable|string',
        ]);

        $complaint->update([
            'status' => $request->status,
            'owner_notes' => $request->owner_notes,
        ]);

        return redirect()->back()->with('success', 'Status laporan komplain berhasil diperbarui.');
    }
}