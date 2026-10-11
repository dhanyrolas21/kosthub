<x-app-layout>
    <!-- Welcome Banner & Quick Action Header -->
    <div class="relative overflow-hidden rounded-2xl glass-panel p-6 sm:p-8 border border-slate-800/80 bg-gradient-to-r from-slate-900 via-brand-900/40 to-slate-900">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold mb-3">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>Ringkasan Real-Time KostHub</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Selamat Datang, Pemilik Kost!</h2>
                <p class="text-slate-400 text-sm mt-1 max-w-xl">Kelola hunian, pantau pemasukan bulanan, verifikasi bukti pembayaran, dan tanggapi keluhan penghuni dalam satu dashboard terpadu.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('owner.tenants.index') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white text-xs font-bold shadow-lg shadow-brand-600/30 transition">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>+ Tambah Penghuni Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Metric Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat 1 -->
        <div class="glass-panel p-5 rounded-2xl relative overflow-hidden group hover:border-brand-500/40 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Kapasitas</p>
                    <h3 class="text-2xl font-black text-white mt-1">{{ $totalRooms }} <span class="text-xs font-normal text-slate-400">Kamar</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-brand-400 group-hover:scale-110 transition">
                    <i data-lucide="door-open" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-400 space-x-1">
                <span class="text-emerald-400 font-bold flex items-center"><i data-lucide="trending-up" class="w-3.5 h-3.5 mr-0.5"></i> 100%</span>
                <span>ketersediaan terdaftar</span>
            </div>
        </div>

        <!-- Stat 2 -->
        <div class="glass-panel p-5 rounded-2xl relative overflow-hidden group hover:border-rose-500/40 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kamar Terisi</p>
                    <h3 class="text-2xl font-black text-white mt-1">{{ $occupiedRooms }} <span class="text-xs font-normal text-slate-400">Kamar</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 group-hover:scale-110 transition">
                    <i data-lucide="user-check" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-400 space-x-1">
                <span class="text-rose-400 font-bold">{{ round(($occupiedRooms / max($totalRooms, 1)) * 100) }}% Occupancy</span>
                <span>({{ $availableRooms }} Kamar Kosong)</span>
            </div>
        </div>

        <!-- Stat 3 -->
        <div class="glass-panel p-5 rounded-2xl relative overflow-hidden group hover:border-emerald-500/40 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pendapatan Bulan Ini</p>
                    <h3 class="text-2xl font-black text-emerald-400 mt-1">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-400 space-x-1">
                <span class="text-emerald-400 font-bold flex items-center"><i data-lucide="arrow-up-right" class="w-3.5 h-3.5 mr-0.5"></i> Verifikasi Lunas</span>
            </div>
        </div>

        <!-- Stat 4 -->
        <div class="glass-panel p-5 rounded-2xl relative overflow-hidden group hover:border-amber-500/40 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kamar Tersedia</p>
                    <h3 class="text-2xl font-black text-amber-400 mt-1">{{ $availableRooms }} <span class="text-xs font-normal text-slate-400">Kamar</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 group-hover:scale-110 transition">
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-amber-300/80 space-x-1">
                <span class="font-bold">Siap Disewakan</span>
            </div>
        </div>
    </div>

    <!-- Main Section: Peta Kamar Terpisah Per Tipe / Harga -->
    <div class="glass-panel p-6 rounded-2xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-800/80 pb-4">
            <div>
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i data-lucide="layout-grid" class="w-5 h-5 text-brand-400"></i>
                    Peta Visual Ketersediaan Kamar
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Kamar dikelompokkan berdasarkan tipe dan harga sewa bulanan.</p>
            </div>
            <div class="flex items-center space-x-4 text-xs font-semibold">
                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-1.5 glow-emerald"></span> Kosong ({{ $availableRooms }})</span>
                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 mr-1.5 glow-rose"></span> Terisi ({{ $occupiedRooms }})</span>
            </div>
        </div>

        @php
            $groupedRooms = $rooms->sortBy(fn($r) => (int) $r->room_number)->groupBy('price');
        @endphp

        <div class="space-y-6">
            @foreach($groupedRooms as $price => $roomGroup)
                @php
                    $typeTitle = $price <= 1000000 ? 'Tipe Standard' : ($price <= 2000000 ? 'Tipe Eksklusif' : 'Tipe VIP');
                @endphp
                
                <!-- Group Card Container -->
                <div class="bg-slate-900/60 p-5 rounded-xl border border-slate-800 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800/80 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-400"></span>
                            <h4 class="text-xs font-extrabold text-white uppercase tracking-wider">{{ $typeTitle }}</h4>
                        </div>
                        <span class="text-xs font-bold text-indigo-400 bg-indigo-500/10 px-2.5 py-1 rounded-md border border-indigo-500/20">
                            Rp {{ number_format($price, 0, ',', '.') }} / bulan
                        </span>
                    </div>

                    <!-- Grid Kamar Lebih Lega -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($roomGroup as $room)
                            @php
                                $isOccupied = ($room->status === 'occupied' || $room->is_occupied);
                            @endphp
                            <div class="glass-card p-5 rounded-2xl border-2 {{ $isOccupied ? 'border-rose-500/30 bg-rose-500/5 glow-rose' : 'border-emerald-500/30 bg-emerald-500/5 glow-emerald' }} transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-extrabold {{ $isOccupied ? 'text-rose-400' : 'text-emerald-400' }}">Kamar {{ $room->room_number }}</span>
                                    <span class="w-2.5 h-2.5 rounded-full {{ $isOccupied ? 'bg-rose-400' : 'bg-emerald-400' }}"></span>
                                </div>
                                <p class="text-xs text-slate-300 font-semibold truncate">
                                    {{ $isOccupied ? 'Terisi' : 'Tersedia' }}
                                </p>
                                <span class="mt-4 block text-center text-xs font-bold py-2 rounded-xl {{ $isOccupied ? 'bg-rose-500/20 text-rose-300' : 'bg-emerald-500/20 text-emerald-300' }}">
                                    {{ $isOccupied ? 'TERISI' : 'KOSONG' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Transaction History Table -->
    <div class="glass-panel p-6 rounded-2xl space-y-4">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i data-lucide="receipt" class="w-5 h-5 text-emerald-400"></i>
                Riwayat Pembayaran Lunas (Bulan Ini)
            </h3>
            <span class="text-xs text-slate-400">Terverifikasi Otomatis & Manual</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="text-slate-400 uppercase bg-slate-900/80 rounded-lg text-[10px] tracking-wider">
                    <tr>
                        <th class="p-3 rounded-l-lg">Penghuni</th>
                        <th class="p-3">Kamar</th>
                        <th class="p-3">Nominal</th>
                        <th class="p-3">Tanggal Verifikasi</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right rounded-r-lg">Aksi Kwitansi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($paymentHistory as $history)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="p-3 font-bold text-white flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-brand-500/20 text-brand-300 flex items-center justify-center text-[10px]">
                                    {{ strtoupper(substr($history->invoice?->tenant?->user?->name ?? 'P', 0, 2)) }}
                                </div>
                                {{ $history->invoice?->tenant?->user?->name ?? 'Penghuni' }}
                            </td>
                            <td class="p-3 text-indigo-400 font-bold">Kamar {{ $history->invoice?->room?->room_number ?? '-' }}</td>
                            <td class="p-3 font-extrabold text-emerald-400">Rp {{ number_format($history->invoice?->amount ?? 0, 0, ',', '.') }}</td>
                            <td class="p-3 text-slate-400">{{ $history->updated_at->format('d M Y, H:i') }} WIB</td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">LUNAS</span>
                            </td>
                            <td class="p-3 text-right">
                                <a href="{{ route('payments.receipt', $history->id) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg bg-brand-600/20 hover:bg-brand-600/40 text-brand-300 text-[11px] font-bold border border-brand-500/30 transition">
                                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                    <span>Cetak PDF</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-500">Belum ada riwayat pembayaran lunas bulan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>