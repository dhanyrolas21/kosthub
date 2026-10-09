<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pemilik Kost
        $owner = User::create([
            'name' => 'Pemilik Kost',
            'email' => 'owner@kosthub.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567890',
        ]);

        // 2. Akun Penghuni
        $tenantUser = User::create([
            'name' => 'Penghuni Kost',
            'email' => 'tenant@kosthub.com',
            'password' => Hash::make('password'),
            'role' => 'tenant',
            'phone' => '089876543210',
        ]);

        // 3. Tambah Kamar
        $room1 = Room::create([
            'room_number' => '101',
            'price' => 800000,
            'status' => 'occupied',
            'description' => 'Kamar Mandi Dalam, AC, Kasur Springbed',
        ]);

        Room::create([
            'room_number' => '102',
            'price' => 750000,
            'status' => 'available',
            'description' => 'Kamar Mandi Luar, Kipas Angin',
        ]);

        // 4. Hubungkan Penghuni ke Kamar 101
        Tenant::create([
            'user_id' => $tenantUser->id,
            'room_id' => $room1->id,
            'start_date' => '2026-10-01',
            'is_active' => true,
        ]);
    }
}
