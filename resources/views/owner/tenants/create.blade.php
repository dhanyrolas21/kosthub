<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Room;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with(['user', 'room'])->latest()->get();
        return view('owner.tenants.index', compact('tenants'));
    }

    public function create()
    {
        // Ambil kamar yang belum terisi
        $availableRooms = Room::where('is_occupied', false)->get();
        return view('owner.tenants.create', compact('availableRooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
        ]);

        // 1. Buat User Penghuni Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'), // password default
            'role' => 'tenant',
        ]);

        // 2. Buat Data Tenant
        $startDate = Carbon::parse($request->start_date);
        $dueDate = $startDate->copy()->addMonth();

        $tenant = Tenant::create([
            'user_id' => $user->id,
            'room_id' => $request->room_id,
            'phone' => $request->phone,
            'start_date' => $startDate,
            'due_date' => $dueDate,
        ]);

        // 3. Ubah Status Kamar Menjadi Terisi
        $room = Room::findOrFail($request->room_id);
        $room->update(['is_occupied' => true]);

        // 4. Buat Tagihan Pertama (Invoice)
        Invoice::create([
            'tenant_id' => $tenant->id,
            'room_id' => $room->id,
            'amount' => $room->price,
            'due_date' => $dueDate,
            'status' => 'unpaid',
        ]);

        return redirect()->route('owner.tenants.index')->with('success', 'Penghuni baru berhasil didaftarkan!');
    }
}