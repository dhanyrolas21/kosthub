<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'owner@kosthub.com'],
            [
                'name' => 'Pemilik Kost',
                'password' => Hash::make('password'),
                'role' => 'owner',
            ]
        );

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
    }
}