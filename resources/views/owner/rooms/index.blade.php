<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Kamar</h2>
            <a href="{{ route('owner.rooms.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">+ Tambah Kamar</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Kamar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Sewa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fasilitas / Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rooms as $room)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-bold">Kamar {{ $room->room_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-bold rounded {{ $room->status === 'occupied' ? 'bg-red-100 text-red-800' : ($room->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ strtoupper($room->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $room->description ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                <a href="{{ route('owner.rooms.edit', $room->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm">Edit</a>
                                <form action="{{ route('owner.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kamar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data kamar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>