<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Kerusakan & Komplain Fasilitas
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Kirim Laporan --}}
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <h3 class="text-base font-bold text-gray-800 mb-4">Buat Laporan Baru</h3>
            <form action="{{ route('tenant.complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Judul / Masalah Kerusakan</label>
                    <input type="text" name="title" placeholder="Contoh: AC Kamar 6 Tidak Dingin / Kran Air Bocor" required style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Deskripsi Detail</label>
                    <textarea name="description" rows="3" placeholder="Jelaskan detail kendala kerusakan yang dialami..." required style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Foto Bukti Kerusakan (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg">
                </div>
                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar Laporan Kerusakan --}}
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <div class="p-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-sm font-bold text-gray-700">Riwayat Laporan Kerusakan Anda</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">Masalah</th>
                        <th class="px-6 py-3 text-left">Foto</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Tanggapan Pemilik</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($complaints as $complaint)
                        <tr>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $complaint->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-800">{{ $complaint->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $complaint->description }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($complaint->image)
                                    <a href="{{ asset('storage/' . $complaint->image) }}" target="_blank" class="text-blue-600 underline font-semibold text-xs">Lihat Foto</a>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($complaint->status === 'resolved')
                                    <span class="px-2.5 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">Selesai Ditangani</span>
                                @elseif($complaint->status === 'in_progress')
                                    <span class="px-2.5 py-1 text-xs font-bold bg-blue-100 text-blue-700 rounded-full">Sedang Diproses</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full">Menunggu Respon</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">
                                {{ $complaint->owner_notes ?? 'Belum ada tanggapan' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 text-xs">
                                Belum ada laporan kerusakan yang diajukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 