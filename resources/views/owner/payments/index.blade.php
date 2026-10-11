<x-app-layout>
    <!-- Header Page Banner -->
    <div class="relative overflow-hidden rounded-2xl glass-panel p-6 sm:p-8 border border-slate-800/80 bg-gradient-to-r from-slate-900 via-brand-900/40 to-slate-900 mb-6">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold mb-3">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                    <span>Verifikasi Keuangan</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Verifikasi Pembayaran</h2>
                <p class="text-slate-400 text-sm mt-1">Periksa bukti transfer dan konfirmasi pembayaran dari penghuni kost.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl font-bold text-xs flex items-center gap-2 shadow-lg">
            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Main Table Glassmorphism Container -->
    <div class="glass-panel rounded-2xl overflow-hidden shadow-xl border border-slate-800">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <h3 class="text-xs font-extrabold text-slate-300 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i>
                Daftar Pembayaran Menunggu Konfirmasi
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="text-slate-400 uppercase bg-slate-900/80 rounded-lg text-[10px] tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="p-4">Penghuni</th>
                        <th class="p-4">Kamar</th>
                        <th class="p-4">Nominal</th>
                        <th class="p-4">Bukti Transfer</th>
                        <th class="p-4">Catatan & Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($pendingPayments as $payment)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="p-4 font-bold text-white flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-brand-500/20 text-brand-300 flex items-center justify-center text-xs font-black">
                                    {{ strtoupper(substr(optional(optional(optional($payment->invoice)->tenant)->user)->name ?? 'B', 0, 2)) }}
                                </div>
                                {{ optional(optional(optional($payment->invoice)->tenant)->user)->name ?? 'Budi' }}
                            </td>
                            <td class="p-4 text-indigo-400 font-bold">
                                Kamar {{ optional(optional($payment->invoice)->room)->room_number ?? '6' }}
                            </td>
                            <td class="p-4 font-black text-emerald-400 text-sm">
                                Rp {{ number_format(optional($payment->invoice)->amount ?? 1500000, 0, ',', '.') }}
                            </td>
                            <td class="p-4">
                                @if(isset($payment->proof_image) && $payment->proof_image)
                                    <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 font-bold border border-indigo-500/30 transition">
                                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                        <span>Lihat Bukti Foto</span>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-500">Tidak Ada Berkas</span>
                                @endif
                            </td>
                            <td class="p-4 min-w-[280px]">
                                <!-- Form Proteksi Double Click dengan Alpine.js -->
                                <form 
                                    action="{{ route('owner.payments.verify', $payment->id) }}" 
                                    method="POST" 
                                    class="space-y-2.5" 
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
                                        class="w-full px-3 py-2 bg-slate-900/90 text-white placeholder-slate-500 border border-slate-700/80 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 font-medium transition"
                                    >
                                    
                                    <div class="flex items-center gap-2" :class="{ 'pointer-events-none opacity-50': submitted }">
                                        <button 
                                            type="submit" 
                                            @click="actionVal = 'approve'"
                                            :disabled="submitted"
                                            class="flex-1 py-2 px-3 bg-emerald-600 hover:bg-emerald-500 disabled:opacity-50 text-white rounded-xl font-bold text-xs shadow-lg shadow-emerald-600/20 transition active:scale-95 flex items-center justify-center gap-1"
                                        >
                                            <i data-lucide="check" class="w-3.5 h-3.5" x-show="!submitted"></i>
                                            <span x-text="submitted && actionVal === 'approve' ? 'Memproses...' : 'SETUJUI'"></span>
                                        </button>
                                        <button 
                                            type="submit" 
                                            @click="actionVal = 'reject'"
                                            :disabled="submitted"
                                            class="flex-1 py-2 px-3 bg-rose-600 hover:bg-rose-500 disabled:opacity-50 text-white rounded-xl font-bold text-xs shadow-lg shadow-rose-600/20 transition active:scale-95 flex items-center justify-center gap-1"
                                        >
                                            <i data-lucide="x" class="w-3.5 h-3.5" x-show="!submitted"></i>
                                            <span x-text="submitted && actionVal === 'reject' ? 'Memproses...' : 'TOLAK'"></span>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                Tidak ada pembayaran yang menunggu verifikasi saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>