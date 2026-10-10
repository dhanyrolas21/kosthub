<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Verifikasi Pembayaran</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden border">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Penghuni</th>
                        <th class="px-6 py-3 text-left">Kamar</th>
                        <th class="px-6 py-3 text-left">Nominal</th>
                        <th class="px-6 py-3 text-left">Bukti Transfer</th>
                        <th class="px-6 py-3 text-left">Catatan / Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse($pendingPayments as $payment)
                        <tr>
                            <td class="px-6 py-4 font-bold">
                                {{ optional(optional(optional($payment->invoice)->tenant)->user)->name ?? 'budi' }}
                            </td>
                            <td class="px-6 py-4">
                                Kamar {{ optional(optional($payment->invoice)->room)->room_number ?? '6' }}
                            </td>
                            <td class="px-6 py-4 font-bold text-blue-600">
                                Rp {{ number_format(optional($payment->invoice)->amount ?? 1500000, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if(isset($payment->proof_image) && $payment->proof_image)
                                    <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="text-blue-600 underline font-semibold hover:text-blue-800">
                                        Lihat Bukti Foto
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">Lihat Bukti Foto</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('owner.payments.verify', $payment->id) }}" method="POST" class="flex flex-col space-y-2">
                                    @csrf
                                    <input type="text" name="notes" placeholder="Catatan/Alasan (Opsional)" class="w-full text-xs border border-gray-300 rounded p-1.5 focus:ring-1 focus:ring-blue-500">
                                    
                                    <!-- TOMBOL SETUJUI & TOLAK TERPISAH KILAT -->
                                    <div style="display: flex !important; gap: 8px !important; align-items: center !important; margin-top: 6px !important;">
                                        <button type="submit" name="action" value="approve" style="background-color: #16a34a !important; color: #ffffff !important; padding: 6px 16px !important; border-radius: 6px !important; font-weight: bold !important; font-size: 12px !important; border: none !important; cursor: pointer !important;">
                                            SETUJUI
                                        </button>
                                        <button type="submit" name="action" value="reject" style="background-color: #dc2626 !important; color: #ffffff !important; padding: 6px 16px !important; border-radius: 6px !important; font-weight: bold !important; font-size: 12px !important; border: none !important; cursor: pointer !important;">
                                            TOLAK
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 text-sm">
                                Tidak ada pembayaran yang menunggu verifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>