<x-app-layout>
    <div class="space-y-6">
        <!-- Banner Utama (Ukuran Tetap Besar & Tinggi, Teks Diberi Padding Pas di Tengah) -->
        <div class="relative overflow-hidden rounded-3xl p-8 sm:p-10 shadow-xl" style="background: linear-gradient(135deg, #4c1d95 0%, #312e81 50%, #581c87 100%); min-height: 180px;">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 h-full my-auto">
                <div class="space-y-3 py-2">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full" style="background-color: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff;">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        <span class="text-xs sm:text-sm font-bold">Ringkasan Real-Time KostHub</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight" style="color: #ffffff !important;">
                        Selamat Datang, Pemilik Kost!
                    </h2>
                    <p class="text-sm sm:text-base font-medium max-w-2xl" style="color: #f3e8ff !important; line-height: 1.6;">
                        Kelola hunian, pantau pemasukan bulanan, verifikasi bukti pembayaran, dan tanggapi keluhan penghuni dalam satu dashboard terpadu.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'owner-guide-modal')" class="inline-flex items-center space-x-2 px-5 py-3 rounded-2xl text-sm font-bold transition cursor-pointer" style="background-color: rgba(255, 255, 255, 0.2); color: #ffffff !important; border: 1px solid rgba(255, 255, 255, 0.35);">
                        <i data-lucide="help-circle" class="w-5 h-5"></i>
                        <span>Cara Pakai Web</span>
                    </button>

                    <a href="{{ route('owner.tenants.create') }}" class="inline-flex items-center space-x-2 px-5 py-3 rounded-2xl text-sm font-black shadow-lg transition cursor-pointer" style="background-color: #ffffff !important; color: #581c87 !important;">
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                        <span>+ Tambah Penghuni Baru</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Stat 1: Total Kapasitas -->
            <div class="p-6 rounded-3xl shadow-sm hover:shadow-md transition dark:bg-slate-800 dark:border-slate-700" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-wider dark:text-gray-400" style="color: #6b7280;">Total Kapasitas</p>
                        <h3 class="text-3xl font-black mt-1 dark:text-white" style="color: #111827;">{{ $totalRooms }} <span class="text-sm font-bold dark:text-gray-400" style="color: #6b7280;">Kamar</span></h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center dark:bg-purple-900/40 dark:text-purple-300" style="background-color: #f3e8ff; color: #6b21a8;">
                        <i data-lucide="door-open" class="w-7 h-7"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm space-x-1" style="color: #4b5563;">
                    <span class="font-extrabold flex items-center" style="color: #059669;"><i data-lucide="trending-up" class="w-4 h-4 mr-1"></i> 100%</span>
                    <span class="font-semibold dark:text-gray-400">ketersediaan terdaftar</span>
                </div>
            </div>

            <!-- Stat 2: Kamar Terisi -->
            <div class="p-6 rounded-3xl shadow-sm hover:shadow-md transition dark:bg-slate-800 dark:border-slate-700" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-wider dark:text-gray-400" style="color: #6b7280;">Kamar Terisi</p>
                        <h3 class="text-3xl font-black mt-1 dark:text-white" style="color: #111827;">{{ $occupiedRooms }} <span class="text-sm font-bold dark:text-gray-400" style="color: #6b7280;">Kamar</span></h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center dark:bg-rose-900/40 dark:text-rose-300" style="background-color: #ffe4e6; color: #e11d48;">
                        <i data-lucide="user-check" class="w-7 h-7"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm space-x-1">
                    <span class="font-extrabold" style="color: #be123c;">{{ round(($occupiedRooms / max($totalRooms, 1)) * 100) }}% Occupancy</span>
                    <span class="font-semibold dark:text-gray-400" style="color: #4b5563;">({{ $availableRooms }} Kamar Kosong)</span>
                </div>
            </div>

            <!-- Stat 3: Pendapatan Bulan Ini -->
            <div class="p-6 rounded-3xl shadow-sm hover:shadow-md transition dark:bg-slate-800 dark:border-slate-700" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-wider dark:text-gray-400" style="color: #6b7280;">Pendapatan Bulan Ini</p>
                        <h3 class="text-2xl font-black mt-1 dark:text-purple-300" style="color: #6b21a8;">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center dark:bg-emerald-900/40 dark:text-emerald-300" style="background-color: #d1fae5; color: #059669;">
                        <i data-lucide="wallet" class="w-7 h-7"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm font-extrabold space-x-1" style="color: #059669;">
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                    <span>Verifikasi Lunas</span>
                </div>
            </div>

            <!-- Stat 4: Kamar Tersedia -->
            <div class="p-6 rounded-3xl shadow-sm hover:shadow-md transition dark:bg-slate-800 dark:border-slate-700" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-wider dark:text-gray-400" style="color: #6b7280;">Kamar Tersedia</p>
                        <h3 class="text-3xl font-black mt-1 dark:text-amber-400" style="color: #d97706;">{{ $availableRooms }} <span class="text-sm font-bold dark:text-gray-400" style="color: #6b7280;">Kamar</span></h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center dark:bg-amber-900/40 dark:text-amber-300" style="background-color: #fef3c7; color: #d97706;">
                        <i data-lucide="sparkles" class="w-7 h-7"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm font-extrabold space-x-1" style="color: #b45309;">
                    <span class="dark:text-amber-400">Siap Disewakan</span>
                </div>
            </div>
        </div>

        <!-- Main Section: Peta Kamar -->
        <div class="p-6 sm:p-8 rounded-3xl shadow-sm space-y-6 dark:bg-slate-800 dark:border-slate-700" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 dark:border-slate-700" style="border-bottom: 2px solid #f3e8ff;">
                <div>
                    <h3 class="text-xl font-black flex items-center gap-2 dark:text-white" style="color: #111827;">
                        <i data-lucide="layout-grid" class="w-6 h-6 dark:text-purple-400" style="color: #7e22ce;"></i>
                        Peta Visual Ketersediaan Kamar
                    </h3>
                    <p class="text-sm mt-1 font-medium dark:text-gray-400" style="color: #6b7280;">Kamar dikelompokkan berdasarkan tipe dan harga sewa bulanan.</p>
                </div>
                <div class="flex items-center space-x-5 text-sm font-black dark:text-gray-300" style="color: #374151;">
                    <span class="flex items-center"><span class="w-3.5 h-3.5 rounded-full mr-2" style="background-color: #10b981;"></span> Kosong ({{ $availableRooms }})</span>
                    <span class="flex items-center"><span class="w-3.5 h-3.5 rounded-full mr-2" style="background-color: #f43f5e;"></span> Terisi ({{ $occupiedRooms }})</span>
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
                    
                    <div class="p-6 rounded-3xl space-y-5 dark:bg-slate-900/60 dark:border-slate-700" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                        <div class="flex items-center justify-between pb-4 dark:border-slate-700" style="border-bottom: 2px solid #e9d5ff;">
                            <div class="flex items-center gap-2.5">
                                <span class="w-3 h-3 rounded-full" style="background-color: #7e22ce;"></span>
                                <h4 class="text-sm font-black uppercase tracking-wider dark:text-purple-300" style="color: #581c87;">{{ $typeTitle }}</h4>
                            </div>
                            <span class="text-sm font-extrabold px-4 py-1.5 rounded-full dark:bg-purple-900/50 dark:text-purple-200" style="background-color: #f3e8ff; color: #6b21a8;">
                                Rp {{ number_format($price, 0, ',', '.') }} / bulan
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                            @foreach($roomGroup as $room)
                                @php
                                    $isOccupied = ($room->status === 'occupied' || $room->is_occupied == 1 || (isset($room->tenants_count) && $room->tenants_count > 0));
                                @endphp
                                
                                <div class="p-5 rounded-2xl transition hover:-translate-y-1 shadow-sm" style="{{ $isOccupied ? 'background-color: #ffe4e6 !important; border: 2px solid #f43f5e !important;' : 'background-color: #ecfdf5 !important; border: 2px solid #10b981 !important;' }}">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-base font-black" style="{{ $isOccupied ? 'color: #be123c !important;' : 'color: #047857 !important;' }}">Kamar {{ $room->room_number }}</span>
                                        <span class="w-3.5 h-3.5 rounded-full" style="{{ $isOccupied ? 'background-color: #f43f5e !important;' : 'background-color: #10b981 !important;' }}"></span>
                                    </div>
                                    <p class="text-xs font-extrabold truncate" style="{{ $isOccupied ? 'color: #be123c !important;' : 'color: #047857 !important;' }}">
                                        {{ $isOccupied ? 'Terisi' : 'Tersedia' }}
                                    </p>
                                    <span class="mt-4 block text-center text-xs font-black py-2.5 rounded-xl uppercase shadow-sm" style="{{ $isOccupied ? 'background-color: #f43f5e !important; color: #ffffff !important;' : 'background-color: #10b981 !important; color: #ffffff !important;' }}">
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
        <div class="p-6 sm:p-8 rounded-3xl shadow-sm space-y-5 dark:bg-slate-800 dark:border-slate-700" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
            <div class="flex items-center justify-between pb-4 dark:border-slate-700" style="border-bottom: 2px solid #f3e8ff;">
                <h3 class="text-lg font-black flex items-center gap-2 dark:text-white" style="color: #111827;">
                    <i data-lucide="receipt" class="w-6 h-6" style="color: #059669;"></i>
                    Riwayat Pembayaran Lunas (Bulan Ini)
                </h3>
                <span class="text-xs font-bold dark:text-gray-400" style="color: #6b7280;">Terverifikasi Otomatis & Manual</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="uppercase rounded-xl text-xs tracking-wider dark:bg-slate-900 dark:text-purple-300" style="background-color: #f3e8ff; color: #581c87;">
                        <tr>
                            <th class="p-4 rounded-l-xl font-black">Penghuni</th>
                            <th class="p-4 font-black">Kamar</th>
                            <th class="p-4 font-black">Nominal</th>
                            <th class="p-4 font-black">Tanggal Verifikasi</th>
                            <th class="p-4 font-black">Status</th>
                            <th class="p-4 text-right rounded-r-xl font-black">Aksi Kwitansi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y font-bold text-sm dark:border-slate-700 dark:text-gray-200" style="border-color: #f3e8ff; color: #1f2937;">
                        @forelse($paymentHistory as $history)
                            <tr class="transition dark:border-slate-700" style="border-bottom: 1px solid #f3e8ff;">
                                <td class="p-4 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black dark:bg-purple-900/60 dark:text-purple-200" style="background-color: #e9d5ff; color: #581c87;">
                                        {{ strtoupper(substr($history->invoice?->tenant?->user?->name ?? 'P', 0, 2)) }}
                                    </div>
                                    <span class="font-extrabold dark:text-white" style="color: #111827;">{{ $history->invoice?->tenant?->user?->name ?? 'Penghuni' }}</span>
                                </td>
                                <td class="p-4 font-black dark:text-purple-300" style="color: #6b21a8;">Kamar {{ $history->invoice?->room?->room_number ?? '-' }}</td>
                                <td class="p-4 font-black" style="color: #059669;">Rp {{ number_format($history->invoice?->amount ?? 0, 0, ',', '.') }}</td>
                                <td class="p-4 font-medium dark:text-gray-400" style="color: #6b7280;">{{ $history->updated_at->format('d M Y, H:i') }} WIB</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-black" style="background-color: #d1fae5; color: #047857; border: 1px solid #a7f3d0;">LUNAS</span>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('payments.receipt', $history->id) }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl text-xs font-extrabold transition dark:bg-purple-900/50 dark:text-purple-200" style="background-color: #f3e8ff; color: #581c87;">
                                        <i data-lucide="file-text" class="w-4 h-4"></i>
                                        <span>Cetak PDF</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center font-medium text-sm dark:text-gray-400" style="color: #9ca3af;">Belum ada riwayat pembayaran lunas bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL PANDUAN CARA PAKAI -->
    <x-modal name="owner-guide-modal" focusable>
        <div class="p-6 rounded-3xl space-y-5 dark:bg-slate-800" style="background-color: #ffffff;">
            <div class="flex items-center justify-between pb-3 dark:border-slate-700" style="border-bottom: 1px solid #f3e8ff;">
                <h3 class="text-xl font-black flex items-center gap-2 dark:text-white" style="color: #111827;">
                    <i data-lucide="book-open" class="w-6 h-6" style="color: #7e22ce;"></i>
                    Panduan Penggunaan Web (Pemilik Kost)
                </h3>
                <button x-on:click="$dispatch('close')" style="color: #9ca3af;">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <div class="space-y-4 text-sm leading-relaxed dark:text-gray-300" style="color: #374151;">
                <div class="p-4 rounded-2xl dark:bg-slate-900/70 dark:border-slate-700" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                    <h4 class="font-black mb-1 dark:text-purple-300" style="color: #581c87;">1. Mendaftarkan Penghuni Baru</h4>
                    <p>Buka menu <b>Manajemen Penghuni</b> atau klik tombol <b>+ Tambah Penghuni Baru</b>. Masukkan data nama, email, dan pilih nomor kamar.</p>
                </div>

                <div class="p-4 rounded-2xl dark:bg-slate-900/70 dark:border-slate-700" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                    <h4 class="font-black mb-1 dark:text-purple-300" style="color: #581c87;">2. Kelola Ketersediaan Kamar</h4>
                    <p>Buka menu <b>Manajemen Kamar</b> untuk menambah kamar baru, menentukan tipe kamar (Standard/Eksklusif/VIP), atau mengatur harga sewa bulanan.</p>
                </div>

                <div class="p-4 rounded-2xl dark:bg-slate-900/70 dark:border-slate-700" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                    <h4 class="font-black mb-1 dark:text-purple-300" style="color: #581c87;">3. Verifikasi Pembayaran Sewa</h4>
                    <p>Masuk ke menu <b>Verifikasi Pembayaran</b> untuk mengecek bukti transfer dari penghuni. Klik <i>Verifikasi</i> agar status menjadi LUNAS dan kwitansi PDF diterbitkan.</p>
                </div>

                <div class="p-4 rounded-2xl dark:bg-slate-900/70 dark:border-slate-700" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                    <h4 class="font-black mb-1 dark:text-purple-300" style="color: #581c87;">4. Menanggapi Laporan Kerusakan</h4>
                    <p>Buka menu <b>Laporan Kerusakan</b> untuk melihat keluhan/fasilitas rusak dari anak kost dan memberikan balasan penanganan.</p>
                </div>
            </div>

            <div class="pt-2 text-right">
                <button x-on:click="$dispatch('close')" class="px-6 py-3 rounded-xl text-xs font-black transition shadow-sm cursor-pointer" style="background-color: #7e22ce; color: #ffffff;">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </x-modal>
</x-app-layout>