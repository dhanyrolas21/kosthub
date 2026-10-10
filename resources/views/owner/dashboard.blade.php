<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Pemilik Kost</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        {{-- Card Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-blue-500">
                <p class="text-xs text-gray-500 font-bold uppercase">Total Kamar</p>
                <p class="text-2xl font-black text-gray-800 mt-1">{{ $totalRooms }}</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-red-500">
                <p class="text-xs text-gray-500 font-bold uppercase">Kamar Terisi</p>
                <p class="text-2xl font-black text-gray-800 mt-1">{{ $occupiedRooms }}</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-green-500">
                <p class="text-xs text-gray-500 font-bold uppercase">Kamar Kosong</p>
                <p class="text-2xl font-black text-gray-800 mt-1">{{ $availableRooms }}</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-emerald-500">
                <p class="text-xs text-gray-500 font-bold uppercase">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-black text-gray-800 mt-1">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Visualisasi Peta Kamar --}}
        <div class="bg-white p-6 rounded-lg shadow border">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-700 text-lg">Peta Kamar</h3>
                <div class="flex space-x-4 text-xs font-semibold">
                    <span class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded-full inline-block mr-1"></span> Kosong</span>
                    <span class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded-full inline-block mr-1"></span> Terisi</span>
                </div>
            </div>
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                @foreach($rooms as $room)
                    <div class="p-3 text-center rounded-lg font-bold text-white shadow-sm transition {{ $room->status === 'occupied' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                        Kamar {{ $room->room_number }}
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tabel Riwayat Pembayaran Bulan Ini --}}
        <div class="bg-white rounded-lg shadow border overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="font-bold text-gray-700 text-md">Riwayat Pembayaran Lunas (Bulan Ini)</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Penghuni</th>
                        <th class="px-6 py-3 text-left">Kamar</th>
                        <th class="px-6 py-3 text-left">Nominal</th>
                        <th class="px-6 py-3 text-left">Tanggal Verifikasi</th>
                        <th class="px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse($paymentHistory as $history)
                        <tr>
                            <td class="px-6 py-4 font-semibold">{{ $history->invoice?->tenant?->user?->name ?? 'Penghuni' }}</td>
                            <td class="px-6 py-4">Kamar {{ $history->invoice?->room?->room_number ?? '-' }}</td>
                            <td class="px-6 py-4 font-bold text-emerald-600">Rp {{ number_format($history->invoice?->amount ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $history->updated_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded-full font-bold">LUNAS</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-400 text-sm">Belum ada riwayat pembayaran yang disetujui bulan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>