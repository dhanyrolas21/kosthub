<x-app-layout>
    <div class="space-y-6">
        <!-- Header Page Banner (Ungu Pekat Gradient - Soft Light Style) -->
        <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 shadow-xl" style="background: linear-gradient(135deg, #4c1d95 0%, #312e81 50%, #581c87 100%); color: #ffffff !important;">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full mb-3" style="background-color: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff;">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        <span class="text-xs font-bold">Verifikasi Keuangan</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight" style="color: #ffffff !important;">Verifikasi Pembayaran</h2>
                    <p class="text-sm mt-1 max-w-xl font-medium" style="color: #e9d5ff !important;">Periksa bukti transfer dan konfirmasi pembayaran dari penghuni kost.</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-2xl font-bold text-xs flex items-center gap-2 shadow-sm" style="background-color: #d1fae5; border: 1px solid #a7f3d0; color: #047857;">
                <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Main Table Container -->
        <div class="p-6 sm:p-8 rounded-3xl shadow-sm space-y-5" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
            <div class="flex items-center justify-between pb-4" style="border-bottom: 2px solid #f3e8ff;">
                <h3 class="text-base font-black flex items-center gap-2" style="color: #111827;">
                    <i data-lucide="clock" class="w-5 h-5" style="color: #d97706;"></i>
                    DAFTAR PEMBAYARAN MENUNGGU KONFIRMASI
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="uppercase rounded-xl text-[10px] tracking-wider" style="background-color: #f3e8ff; color: #581c87;">
                        <tr>
                            <th class="p-4 rounded-l-xl font-black">Penghuni</th>
                            <th class="p-4 font-black">Kamar</th>
                            <th class="p-4 font-black">Nominal</th>
                            <th class="p-4 font-black">Bukti Transfer</th>
                            <th class="p-4 text-right rounded-r-xl font-black">Catatan & Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y font-bold" style="border-color: #f3e8ff;">
                        @forelse($pendingPayments as $payment)
                            <tr class="transition" style="border-bottom: 1px solid #f3e8ff;">
                                <!-- Nama Penghuni -->
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-black shrink-0" style="background-color: #7e22ce; color: #ffffff;">
                                            {{ strtoupper(substr(optional(optional(optional($payment->invoice)->tenant)->user)->name ?? 'B', 0, 2)) }}
                                        </div>
                                        <span class="text-sm font-black" style="color: #111827 !important;">
                                            {{ optional(optional(optional($payment->invoice)->tenant)->user)->name ?? 'Budi' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Nomor Kamar -->
                                <td class="p-4 text-sm font-black" style="color: #581c87;">
                                    Kamar {{ optional(optional($payment->invoice)->room)->room_number ?? '6' }}
                                </td>

                                <!-- Nominal Tagihan -->
                                <td class="p-4 text-base font-black" style="color: #059669;">
                                    Rp {{ number_format(optional($payment->invoice)->amount ?? 1500000, 0, ',', '.') }}
                                </td>

                                <!-- Foto Bukti Transfer -->
                                <td class="p-4">
                                    @if(isset($payment->proof_image) && $payment->proof_image)
                                        <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-extrabold transition shadow-sm" style="background-color: #f3e8ff; color: #581c87; border: 1px solid #c084fc;">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                            <span>Lihat Bukti Foto</span>
                                        </a>
                                    @else
                                        <span class="text-xs font-medium" style="color: #9ca3af;">Tidak Ada Berkas</span>
                                    @endif
                                </td>

                                <!-- Form Aksi dengan Alpine.js (Proteksi Double Click & Tombol Kontras Pekat) -->
                                <td class="p-4 min-w-[300px] text-right">
                                    <form 
                                        action="{{ route('owner.payments.verify', $payment->id) }}" 
                                        method="POST" 
                                        class="space-y-2.5 inline-block text-left w-full sm:w-auto" 
                                        x-data="{ submitted: false, actionVal: '' }" 
                                        @submit="submitted = true"
                                    >
                                        @csrf
                                        <input type="hidden" name="action" :value="actionVal">

                                        <input 
                                            type="text" 
                                            name="notes" 
                                            placeholder="Catatan/Alasan (Opsional)" 
                                            :disabled="submitted"
                                            style="color: #111827 !important; background-color: #ffffff !important; border: 1px solid #d1d5db;"
                                            class="w-full px-3 py-2 rounded-xl text-xs font-medium focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                                        >
                                        
                                        <div class="flex items-center justify-end gap-2" :class="{ 'pointer-events-none opacity-50': submitted }">
                                            <!-- Tombol SETUJUI (Hijau Pekat Menyala) -->
                                            <button 
                                                type="submit" 
                                                @click="actionVal = 'approve'"
                                                :disabled="submitted"
                                                class="py-2.5 px-4 text-xs font-black rounded-xl shadow-md transition flex items-center justify-center gap-1.5 cursor-pointer"
                                                style="background-color: #047857 !important; color: #ffffff !important; border: 1px solid #065f46;"
                                            >
                                                <i data-lucide="check" class="w-4 h-4 text-white" x-show="!submitted"></i>
                                                <span x-text="submitted && actionVal === 'approve' ? 'Memproses...' : 'SETUJUI'" style="color: #ffffff !important;"></span>
                                            </button>

                                            <!-- Tombol TOLAK (Merah Pekat) -->
                                            <button 
                                                type="submit" 
                                                @click="actionVal = 'reject'"
                                                :disabled="submitted"
                                                class="py-2.5 px-4 text-xs font-black rounded-xl shadow-md transition flex items-center justify-center gap-1.5 cursor-pointer"
                                                style="background-color: #be123c !important; color: #ffffff !important; border: 1px solid #9f1239;"
                                            >
                                                <i data-lucide="x" class="w-4 h-4 text-white" x-show="!submitted"></i>
                                                <span x-text="submitted && actionVal === 'reject' ? 'Memproses...' : 'TOLAK'" style="color: #ffffff !important;"></span>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center font-medium text-sm" style="color: #9ca3af;">
                                    Tidak ada pembayaran yang menunggu verifikasi saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>