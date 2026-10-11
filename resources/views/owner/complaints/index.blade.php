<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Laporan Kerusakan
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Penghuni / Kamar</th>
                        <th class="px-6 py-3 text-left">Laporan</th>
                        <th class="px-6 py-3 text-left">Bukti Foto</th>
                        <th class="px-6 py-3 text-left">Update Status & Catatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($complaints as $complaint)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-800">{{ $complaint->tenant?->user?->name ?? 'Penghuni' }}</p>
                                <p class="text-xs text-blue-600 font-semibold">Kamar {{ $complaint->room?->room_number ?? '-' }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $complaint->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="font-bold text-gray-800">{{ $complaint->title }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ $complaint->description }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($complaint->image)
                                    <a href="{{ asset('storage/' . $complaint->image) }}" target="_blank" class="text-blue-600 underline font-semibold text-xs">Lihat Bukti Foto</a>
                                @else
                                    <span class="text-xs text-gray-400">Tidak Ada Foto</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('owner.complaints.update', $complaint->id) }}" method="POST" class="space-y-2">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center space-x-2">
                                        <select name="status" class="text-xs border-gray-300 rounded p-1.5 focus:ring-blue-500">
                                            <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $complaint->status === 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                                            <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-blue-700 transition">
                                            Simpan
                                        </button>
                                    </div>
                                    <input type="text" name="owner_notes" value="{{ $complaint->owner_notes }}" placeholder="Tanggapan / Catatan Pemilik" class="w-full text-xs border border-gray-300 rounded p-1.5">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-xs">
                                Belum ada laporan kerusakan dari penghuni.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>