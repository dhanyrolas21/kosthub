<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Pemilik Kost</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Card Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <div class="text-sm text-gray-500">Total Kamar</div>
                <div class="text-2xl font-bold">{{ $totalRooms }}</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                <div class="text-sm text-gray-500">Kamar Terisi</div>
                <div class="text-2xl font-bold">{{ $occupiedRooms }}</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                <div class="text-sm text-gray-500">Kamar Kosong</div>
                <div class="text-2xl font-bold">{{ $availableRooms }}</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-emerald-500">
                <div class="text-sm text-gray-500">Pendapatan Bulan Ini</div>
                <div class="text-2xl font-bold">Rp {{ number_format($currentMonthEarnings, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Grid Status Kamar -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-semibold text-lg mb-4">Peta Kamar</h3>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
                @foreach($rooms as $room)
                    <div class="p-4 rounded-lg text-center font-bold text-white {{ $room->status === 'occupied' ? 'bg-red-500' : ($room->status === 'available' ? 'bg-green-500' : 'bg-yellow-500') }}">
                        Kamar {{ $room->room_number }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>