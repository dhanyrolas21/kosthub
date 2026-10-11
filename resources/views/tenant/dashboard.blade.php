<x-app-layout>
    <!-- Top Banner Tenant -->
    <div class="bg-gradient-to-r from-brand-600 via-indigo-600 to-purple-600 rounded-2xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 translate-x-8 -translate-y-8 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold backdrop-blur-md">
                    <i data-lucide="home" class="w-3.5 h-3.5"></i>
                    <span>Dashboard Penghuni Aktif</span>
                </span>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-brand-100 text-xs sm:text-sm max-w-lg">Selamat datang di portal KostHub Anda. Pantau masa sewa, lakukan pembayaran tagihan bulanan, dan buat laporan komplain fasilitas secara instan.</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/20 text-right min-w-[200px]">
                <p class="text-xs text-brand-100 font-semibold">Status Sewa Kamar</p>
                <p class="text-xl font-black text-white mt-0.5">
                    @if($tenant && $tenant->room)
                        Kamar {{ $tenant->room->room_number }}
                    @else
                        Belum Ada Kamar
                    @endif
                </p>
                <p class="text-xs text-emerald-300 font-bold mt-1">Sewa Aktif</p>
            </div>
        </div>
    </div>

    <!-- Tenant Main Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Active Billing & Upload Form -->
        <div class="md:col-span-2 glass-panel rounded-2xl p-6 space-y-6 shadow-lg">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i data-lucide="credit-card" class="w-5 h-5 text-emerald-400"></i>
                        Tagihan Aktif Periode Ini
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Periode Sewa Bulan Ini</p>
                </div>
                @if($currentInvoice)
                    @if(strtolower($currentInvoice->status) === 'paid')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 glow-emerald">
                            ✓ LUNAS / PAID
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-amber-500/20 text-amber-300 border border-amber-500/40 animate-pulse">
                            ⚠️ BELUM DIBAYAR
                        </span>
                    @endif
                @endif
            </div>

            @if($currentInvoice)
                <div class="bg-slate-900/90 p-5 rounded-2xl border border-slate-700/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase">Total Tagihan Bulanan</p>
                        <p class="text-3xl font-black text-emerald-400 mt-1">Rp {{ number_format($currentInvoice->amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-300 mt-1">Jatuh Tempo: <span class="text-amber-400 font-bold">{{ \Carbon\Carbon::parse($currentInvoice->due_date)->format('d M Y') }}</span></p>
                    </div>
                </div>

                @if(strtolower($currentInvoice->status) !== 'paid')
                    <!-- Box Upload Dibuat Menyala & Kontras -->
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950/40 to-slate-900 border-2 border-indigo-500/50 shadow-xl shadow-indigo-500/10 space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-black text-indigo-300 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="upload-cloud" class="w-4 h-4 text-indigo-400"></i>
                                Upload Bukti Transfer Pembayaran
                            </h4>
                            <span class="text-[10px] font-bold px-2 py-0.5 bg-indigo-500/20 text-indigo-300 rounded border border-indigo-500/30">Langkah Akhir</span>
                        </div>
                        
                        <form action="{{ route('tenant.invoices.pay', $currentInvoice->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div class="relative">
                                <input type="file" name="proof_image" accept="image/*" required class="block w-full text-xs text-slate-200 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-brand-600 file:text-white hover:file:bg-brand-500 border-2 border-indigo-500/30 rounded-xl bg-slate-950/80 cursor-pointer p-1.5 focus:border-indigo-400 transition">
                            </div>
                            <button type="submit" class="w-full py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-black rounded-xl transition shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 uppercase tracking-wider">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                <span>Kirim Bukti Transfer Sekarang</span>
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <p class="text-sm text-slate-400 py-4">Belum ada tagihan aktif untuk Anda.</p>
            @endif
        </div>

        <!-- Checkout Action & Support -->
        <div class="space-y-6">
            <div class="glass-panel rounded-2xl p-6 space-y-4 shadow-lg">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i data-lucide="log-out" class="w-5 h-5 text-rose-400"></i>
                    Aksi Berhenti Sewa (Checkout)
                </h3>
                <p class="text-xs text-slate-400 leading-relaxed">Ingin mengakhiri masa sewa? Pengajuan checkout akan diproses oleh Pemilik Kost untuk mengosongkan status kamar.</p>
                
                @if($tenant && $tenant->checkout_status === 'pending')
                    <div class="p-3 bg-amber-500/10 border border-amber-500/20 text-amber-300 rounded-xl text-xs font-semibold">
                        ⏳ Pengajuan checkout sedang menunggu konfirmasi pemilik.
                    </div>
                @elseif($tenant)
                    <form action="{{ route('tenant.checkout.request') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengajukan berhenti sewa?')">
                        @csrf
                        <button type="submit" class="w-full py-3 px-4 bg-rose-600/20 hover:bg-rose-600 text-rose-300 hover:text-white border border-rose-500/40 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-2 shadow-sm">
                            <i data-lucide="user-x" class="w-4 h-4"></i>
                            <span>Ajukan Berhenti Sewa (Checkout)</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Transaction History Table -->
    <div class="glass-panel p-6 rounded-2xl space-y-4">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i data-lucide="receipt" class="w-5 h-5 text-emerald-400"></i>
                Riwayat Pembayaran & Tagihan
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="text-slate-400 uppercase bg-slate-900/80 rounded-lg text-[10px] tracking-wider">
                    <tr>
                        <th class="p-3 rounded-l-lg">Tanggal Kirim</th>
                        <th class="p-3">Nominal</th>
                        <th class="p-3">Bukti Foto</th>
                        <th class="p-3 text-right rounded-r-lg">Status & Kwitansi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($paymentHistory as $pay)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="p-3 text-slate-300 font-bold">{{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y, H:i') }}</td>
                            <td class="p-3 font-extrabold text-emerald-400">Rp {{ number_format($pay->invoice?->amount ?? 0, 0, ',', '.') }}</td>
                            <td class="p-3">
                                @if($pay->proof_image)
                                    <a href="{{ asset('storage/' . $pay->proof_image) }}" target="_blank" class="text-brand-400 underline font-semibold hover:text-brand-300">Lihat Foto</a>
                                @else
                                    <span class="text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="p-3 text-right">
                                @if(strtolower($pay->status) === 'approved' || strtolower($pay->invoice?->status) === 'paid')
                                    <a href="{{ route('payments.receipt', $pay->id) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg bg-brand-600/20 hover:bg-brand-600/40 text-brand-300 text-[11px] font-bold border border-brand-500/30 transition">
                                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                        <span>Cetak PDF</span>
                                    </a>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-slate-500">Belum ada data riwayat pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>