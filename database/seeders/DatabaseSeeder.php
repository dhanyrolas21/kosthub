<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Pemilik Kost
        User::firstOrCreate(
            ['email' => 'owner@kosthub.com'],
            [
                'name' => 'Pemilik Kost',
                'password' => Hash::make('password'),
                'role' => 'owner',
            ]
        );

        // 2. Generate Data Kamar (1 - 15)
        $roomsData = [];

        // Type Biasa (1-5) - Rp 800.000
        for ($i = 1; $i <= 5; $i++) {
            $roomsData[] = [
                'room_number' => (string) $i,
                'price' => 800000,
                'status' => 'available',
                'description' => 'Tipe Biasa: Kipas Angin, Kamar Mandi Dalam, Kasur, Lemari, Jendela',
            ];
        }

        // Type Eksklusif (6-10) - Rp 1.500.000
        for ($i = 6; $i <= 10; $i++) {
            $roomsData[] = [
                'room_number' => (string) $i,
                'price' => 1500000,
                'status' => 'available',
                'description' => 'Tipe Eksklusif: AC, Wi-Fi, Kamar Mandi Dalam, Meja Belajar, Lemari, Kasur, Water Heater, Jendela',
            ];
        }

        // Type VIP (11-15) - Rp 2.500.000
        for ($i = 11; $i <= 15; $i++) {
            $roomsData[] = [
                'room_number' => (string) $i,
                'price' => 2500000,
                'status' => 'available',
                'description' => 'Tipe VIP: AC, Kamar Mandi Dalam, Meja Belajar, Lemari, Kasur King Size, Wi-Fi, Water Heater, Balkon, Smart TV, Kulkas Mini, Jendela',
            ];
        }

        foreach ($roomsData as $data) {
            Room::updateOrCreate(
                ['room_number' => $data['room_number']],
                $data
            );
        }

        // 3. Buat Akun Penghuni (Budi)
        $userBudi = User::firstOrCreate(
            ['email' => 'budi@kosthub.com'],
            [
                'name' => 'budi',
                'password' => Hash::make('password'),
                'role' => 'tenant',
            ]
        );

        // Update Kamar 6 menjadi Terisi (occupied)
        $room6 = Room::where('room_number', '6')->first();
        if ($room6) {
            $room6->update(['status' => 'occupied']);
        }

        // 4. Buat Data Tenant Budi
        $tenantBudi = Tenant::firstOrCreate(
            ['user_id' => $userBudi->id],
            [
                'room_id' => $room6?->id,
                'phone' => '081234567890',
                'start_date' => Carbon::now(),
                'is_active' => true,
                'checkout_status' => 'none',
            ]
        );

        // 5. Buat Tagihan Aktif Budi
        if ($room6) {
            Invoice::firstOrCreate(
                ['tenant_id' => $tenantBudi->id, 'status' => 'unpaid'],
                [
                    'room_id' => $room6->id,
                    'amount' => $room6->price,
                    'period_month' => Carbon::now()->month,
                    'period_year' => Carbon::now()->year,
                    'due_date' => Carbon::now()->addDays(7),
                    'status' => 'unpaid',
                ]
            );
        }
    }
}