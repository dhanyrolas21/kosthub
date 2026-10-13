<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Kamar Kost</h2>
            <a href="{{ route('owner.rooms.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">+ Tambah Kamar</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif

        @php
            $groupedRooms = [
                'TIPE BIASA (Rp 800.000 / bln)' => $rooms->where('price', '<=', 800000),
                'TIPE EKSKLUSIF (Rp 1.500.000 / bln)' => $rooms->where('price', '>', 800000)->where('price', '<=', 1500000),
                'TIPE VIP (Rp 2.500.000 / bln)' => $rooms->where('price', '>', 1500000),
            ];
        @endphp

        @foreach($groupedRooms as $title => $categoryRooms)
            <div class="bg-white rounded-lg shadow overflow-hidden border">
                <div class="bg-gray-100 px-6 py-3 border-b border-gray-200 font-extrabold text-gray-700 text-md uppercase tracking-wider">
                    {{ $title }}
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-xs font-medium text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">No. Kamar</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Fasilitas / Deskripsi</th>
                            <th class="px-4 py-3 text-center">Edit</th>
                            <th class="px-4 py-3 text-center">Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categoryRooms as $room)
                            <tr>
                                <td class="px-6 py-4 font-bold whitespace-nowrap">Kamar {{ $room->room_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full inline-block {{ $room->status === 'occupied' ? 'bg-red-100 text-red-800' : ($room->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ strtoupper($room->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $room->description }}</td>
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    <a href="{{ route('owner.rooms.edit', $room->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm">Edit</a>
                                </td>
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    <form action="{{ route('owner.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kamar ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-400 text-sm">Belum ada kamar untuk tipe ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</x-app-layout>