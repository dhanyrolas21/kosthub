<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Room;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    public function index()
    {
        // Mengambil semua data penghuni beserta relasi user dan room
        $tenants = Tenant::with(['user', 'room'])->where('is_active', true)->latest()->get();
        return view('owner.tenants.index', compact('tenants'));
    }

    public function create()
    {
        // Mengurutkan nomor kamar secara numerik (1, 2, 3 ... 15)
        $availableRooms = Room::where('status', 'available')
            ->orderByRaw('CAST(room_number AS UNSIGNED) ASC')
            ->get();

        return view('owner.tenants.create', compact('availableRooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $room = Room::findOrFail($request->room_id);

            // 1. Buat akun user untuk penghuni
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password'),
                'role' => 'tenant',
            ]);

            // 2. Buat data tenant
            $tenant = Tenant::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'phone' => $request->phone,
                'start_date' => $request->start_date,
                'is_active' => true,
                'checkout_status' => 'none',
            ]);

            // 3. Ubah status kamar menjadi occupied
            $room->update(['status' => 'occupied']);

            // 4. Otomatis terbitkan tagihan sewa pertama
            Invoice::create([
                'tenant_id' => $tenant->id,
                'room_id' => $room->id,
                'amount' => $room->price,
                'period_month' => now()->month,
                'period_year' => now()->year,
                'due_date' => now()->addDays(7),
                'status' => 'unpaid',
            ]);
        });

        return redirect()->route('owner.tenants.index')->with('success', 'Penghuni baru berhasil didaftarkan (Password bawaan: password). Kamar otomatis berubah menjadi TERISI.');
    }

    /**
     * Persetujuan Pengajuan Checkout dari Penghuni
     */
    public function approveCheckout(Tenant $tenant)
    {
        DB::transaction(function () use ($tenant) {
            // 1. Kosongkan kembali status kamar di peta kamar
            if ($tenant->room_id) {
                Room::where('id', $tenant->room_id)->update(['status' => 'available']);
            }

            // 2. Update status checkout approved dan lepaskan relasi kamar
            $tenant->update([
                'checkout_status' => 'approved',
                'is_active' => false,
                'room_id' => null,
            ]);
        });

        return redirect()->route('owner.tenants.index')->with('success', 'Pengajuan checkout berhasil disetujui. Kamar telah kembali TERSEDIA (KOSONG).');
    }

    public function destroy(Tenant $tenant)
    {
        DB::transaction(function () use ($tenant) {
            // Ubah status kamar kembali menjadi tersedia (available)
            if ($tenant->room_id) {
                Room::where('id', $tenant->room_id)->update(['status' => 'available']);
            }

            // Nonaktifkan status penghuni
            $tenant->update([
                'is_active' => false,
                'checkout_status' => 'approved',
                'room_id' => null,
            ]);
        });

        return redirect()->route('owner.tenants.index')->with('success', 'Penghuni berhasil di-checkout dan kamar kembali KOSONG.');
    }
}