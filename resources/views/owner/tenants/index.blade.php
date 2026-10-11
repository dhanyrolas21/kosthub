<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Penghuni
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-bold text-gray-800">Daftar Penghuni Kost</h3>
            <a href="{{ route('owner.tenants.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition">
                + Tambah Penghuni Baru
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Penghuni</th>
                        <th class="px-6 py-3 text-left">Kamar</th>
                        <th class="px-6 py-3 text-left">No. WhatsApp</th>
                        <th class="px-6 py-3 text-left">Tanggal Mulai</th>
                        <th class="px-6 py-3 text-left">Pengingat WA</th>
                        <th class="px-6 py-3 text-center">Status / Aksi Checkout</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tenants as $tenant)
                        @php
                            // Format nomor telepon ke standar internasional WhatsApp (misal 0812... -> 62812...)
                            $rawPhone = $tenant->phone ?? '081234567890';
                            $formattedPhone = $rawPhone;
                            if (str_starts_with($rawPhone, '0')) {
                                $formattedPhone = '62' . substr($rawPhone, 1);
                            }

                            $nama = $tenant->user?->name ?? 'Penghuni';
                            $kamar = $tenant->room?->room_number ?? '-';
                            $nominal = number_format($tenant->room?->price ?? 1500000, 0, ',', '.');

                            $pesan = "Halo {$nama}, mengingatkan tagihan sewa Kamar {$kamar} di KostHub sebesar Rp {$nominal} untuk periode ini. Mohon segera melakukan pembayaran dan mengunggah bukti transfer melalui sistem. Terima kasih!";
                            $waUrl = "https://wa.me/{$formattedPhone}?text=" . urlencode($pesan);
                        @endphp
                        <tr>
                            <td class="px-6 py-4 font-bold text-gray-800">
                                {{ $tenant->user?->name ?? '-' }}
                                <div class="text-xs font-normal text-gray-400">{{ $tenant->user?->email }}</div>
                            </td>
                            <td class="px-6 py-4 font-bold text-blue-600">
                                Kamar {{ $tenant->room?->room_number ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $tenant->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($tenant->start_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition space-x-1">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.205 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                                    </svg>
                                    <span>Ingatkan WA</span>
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($tenant->checkout_status === 'pending')
                                    <form action="{{ route('owner.tenants.approveCheckout', $tenant->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition shadow-sm" onclick="return confirm('Setujui pengajuan berhenti sewa? Kamar akan kembali TERSEDIA/KOSONG.')">
                                            Setujui Checkout
                                        </button>
                                    </form>
                                @elseif($tenant->checkout_status === 'approved')
                                    <span class="px-2.5 py-1 text-xs font-bold bg-gray-100 text-gray-600 rounded-full">Sudah Keluar</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold bg-blue-50 text-blue-700 rounded-full">Aktif Menyewa</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 text-xs">
                                Belum ada data penghuni.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>