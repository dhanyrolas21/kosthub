<x-app-layout>
    <div class="space-y-6">
        <!-- Top Banner Tenant (Warna Ungu Gradient Pekat - Teks Putih Jelas) -->
        <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 shadow-xl" style="background: linear-gradient(135deg, #4c1d95 0%, #312e81 50%, #581c87 100%); color: #ffffff !important;">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff;">
                        <i data-lucide="home" class="w-3.5 h-3.5"></i>
                        <span>Dashboard Penghuni Aktif</span>
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight" style="color: #ffffff !important;">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-xs sm:text-sm max-w-lg font-medium" style="color: #e9d5ff !important; line-height: 1.5;">Selamat datang di portal KostHub Anda. Pantau masa sewa, lakukan pembayaran tagihan bulanan, dan buat laporan komplain fasilitas secara instan.</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <!-- Tombol Panduan Penghuni -->
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'tenant-guide-modal')" class="inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-2xl text-xs font-bold transition" style="background-color: rgba(255, 255, 255, 0.2); color: #ffffff !important; border: 1px solid rgba(255, 255, 255, 0.35);">
                        <i data-lucide="help-circle" class="w-4 h-4"></i>
                        <span>Cara Pakai Web</span>
                    </button>

                    <div class="p-4 rounded-2xl text-right min-w-[180px]" style="background-color: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25);">
                        <p class="text-xs font-bold" style="color: #e9d5ff;">Status Sewa Kamar</p>
                        <p class="text-xl font-black mt-0.5" style="color: #ffffff;">
                            @if($tenant && $tenant->room)
                                Kamar {{ $tenant->room->room_number }}
                            @else
                                Belum Ada Kamar
                            @endif
                        </p>
                        <p class="text-xs font-black mt-1" style="color: #6ee7b7;">Sewa Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tenant Main Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Active Billing & Upload Form -->
            <div class="md:col-span-2 p-6 rounded-3xl shadow-sm space-y-6" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
                <div class="flex items-center justify-between pb-4" style="border-bottom: 1px solid #f3e8ff;">
                    <div>
                        <h3 class="text-lg font-extrabold flex items-center gap-2" style="color: #111827;">
                            <i data-lucide="credit-card" class="w-5 h-5" style="color: #059669;"></i>
                            Tagihan Aktif Periode Ini
                        </h3>
                        <p class="text-xs mt-0.5 font-medium" style="color: #6b7280;">Periode Sewa Bulan Ini</p>
                    </div>
                    @if($currentInvoice)
                        @if(strtolower($currentInvoice->status) === 'paid')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black" style="background-color: #d1fae5; color: #047857; border: 1px solid #a7f3d0;">
                                ✓ LUNAS / PAID
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                                ⚠️ BELUM DIBAYAR
                            </span>
                        @endif
                    @endif
                </div>

                @if($currentInvoice)
                    <div class="p-5 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider" style="color: #581c87;">Total Tagihan Bulanan</p>
                            <p class="text-3xl font-black mt-1" style="color: #059669;">Rp {{ number_format($currentInvoice->amount, 0, ',', '.') }}</p>
                            <p class="text-xs mt-1 font-medium" style="color: #4b5563;">Jatuh Tempo: <span class="font-bold" style="color: #b45309;">{{ \Carbon\Carbon::parse($currentInvoice->due_date)->format('d M Y') }}</span></p>
                        </div>
                    </div>

                    @if(strtolower($currentInvoice->status) !== 'paid')
                        <!-- Box Upload Resi Transfer -->
                        <div class="p-6 rounded-2xl space-y-4" style="background-color: #faf5ff; border: 2px solid #e9d5ff;">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-black uppercase tracking-wider flex items-center gap-2" style="color: #581c87;">
                                    <i data-lucide="upload-cloud" class="w-4 h-4" style="color: #7e22ce;"></i>
                                    Upload Bukti Transfer Pembayaran
                                </h4>
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full" style="background-color: #f3e8ff; color: #581c87; border: 1px solid #e9d5ff;">Langkah Akhir</span>
                            </div>
                            
                            <form action="{{ route('tenant.invoices.pay', $currentInvoice->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <div>
                                    <input type="file" name="proof_image" accept="image/*" required style="color: #111827 !important; background-color: #ffffff !important;" class="block w-full text-xs text-gray-700 border border-gray-300 rounded-xl p-2 cursor-pointer focus:border-purple-500 transition">
                                </div>
                                <button type="submit" class="w-full py-3 text-xs font-black rounded-xl transition shadow-md flex items-center justify-center gap-2 uppercase tracking-wider" style="background-color: #059669; color: #ffffff;">
                                    <i data-lucide="send" class="w-4 h-4"></i>
                                    <span>Kirim Bukti Transfer Sekarang</span>
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <p class="text-sm py-4 font-normal" style="color: #6b7280;">Belum ada tagihan aktif untuk Anda.</p>
                @endif
            </div>

            <!-- Checkout Action -->
            <div class="space-y-6">
                <div class="p-6 rounded-3xl shadow-sm space-y-4" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
                    <h3 class="text-base font-extrabold flex items-center gap-2" style="color: #111827;">
                        <i data-lucide="log-out" class="w-5 h-5" style="color: #e11d48;"></i>
                        Aksi Berhenti Sewa (Checkout)
                    </h3>
                    <p class="text-xs leading-relaxed font-normal" style="color: #6b7280;">Ingin mengakhiri masa sewa? Pengajuan checkout akan diproses oleh Pemilik Kost untuk mengosongkan status kamar.</p>
                    
                    @if($tenant && $tenant->checkout_status === 'pending')
                        <div class="p-3 rounded-2xl text-xs font-bold" style="background-color: #fef3c7; border: 1px solid #fde68a; color: #92400e;">
                            ⏳ Pengajuan checkout sedang menunggu konfirmasi pemilik.
                        </div>
                    @elseif($tenant)
                        <form action="{{ route('tenant.checkout.request') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengajukan berhenti sewa?')">
                            @csrf
                            <button type="submit" class="w-full py-3 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-2 shadow-sm" style="background-color: #ffe4e6; color: #be123c; border: 1px solid #fecdd3;">
                                <i data-lucide="user-x" class="w-4 h-4"></i>
                                <span>Ajukan Berhenti Sewa (Checkout)</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Transaction History Table -->
        <div class="p-6 rounded-3xl shadow-sm space-y-4" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
            <div class="flex items-center justify-between pb-3" style="border-bottom: 1px solid #f3e8ff;">
                <h3 class="text-base font-extrabold flex items-center gap-2" style="color: #111827;">
                    <i data-lucide="receipt" class="w-5 h-5" style="color: #059669;"></i>
                    Riwayat Pembayaran & Tagihan
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="uppercase rounded-xl text-[10px] tracking-wider" style="background-color: #f3e8ff; color: #581c87;">
                        <tr>
                            <th class="p-3 rounded-l-xl font-black">Tanggal Kirim</th>
                            <th class="p-3 font-black">Nominal</th>
                            <th class="p-3 font-black">Bukti Foto</th>
                            <th class="p-3 text-right rounded-r-xl font-black">Status & Kwitansi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y font-bold" style="border-color: #f3e8ff; color: #1f2937;">
                        @forelse($paymentHistory as $pay)
                            <tr class="transition" style="border-bottom: 1px solid #f3e8ff;">
                                <td class="p-3 font-bold" style="color: #111827;">{{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y, H:i') }} WIB</td>
                                <td class="p-3 font-black" style="color: #059669;">Rp {{ number_format($pay->invoice?->amount ?? 0, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    @if($pay->proof_image)
                                        <a href="{{ asset('storage/' . $pay->proof_image) }}" target="_blank" class="underline font-bold" style="color: #7e22ce;">Lihat Foto</a>
                                    @else
                                        <span class="font-normal" style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td class="p-3 text-right">
                                    @if(strtolower($pay->status) === 'approved' || strtolower($pay->invoice?->status) === 'paid')
                                        <a href="{{ route('payments.receipt', $pay->id) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-[11px] font-bold transition" style="background-color: #f3e8ff; color: #581c87;">
                                            <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                            <span>Cetak PDF</span>
                                        </a>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center font-normal" style="color: #9ca3af;">Belum ada data riwayat pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL PANDUAN CARA PAKAI (SISI PENGHUNI KOST) -->
    <x-modal name="tenant-guide-modal" focusable>
        <div class="p-6 rounded-3xl space-y-5" style="background-color: #ffffff;">
            <div class="flex items-center justify-between pb-3" style="border-bottom: 1px solid #f3e8ff;">
                <h3 class="text-lg font-black flex items-center gap-2" style="color: #111827;">
                    <i data-lucide="book-open" class="w-5 h-5" style="color: #7e22ce;"></i>
                    Panduan Penggunaan Web (Penghuni Kost)
                </h3>
                <button x-on:click="$dispatch('close')" style="color: #9ca3af;">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="space-y-4 text-xs leading-relaxed" style="color: #374151;">
                <div class="p-3.5 rounded-2xl" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                    <h4 class="font-extrabold mb-1" style="color: #581c87;">1. Pembayaran Sewa Bulanan</h4>
                    <p>Periksa nominal tagihan aktif di Dashboard. Unggah foto resi/bukti transfer pada kotak <b>Upload Bukti Transfer Pembayaran</b>, lalu klik tombol kirim. Pemilik akan memverifikasi pembayaran Anda.</p>
                </div>

                <div class="p-3.5 rounded-2xl" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                    <h4 class="font-extrabold mb-1" style="color: #581c87;">2. Melaporkan Kerusakan / Keluhan</h4>
                    <p>Buka menu <b>Laporan Kerusakan</b> di navigasi kiri. Isi judul kendala (misal: AC tidak dingin, kran air bocor), deskripsi detail, serta foto bukti pendukung agar pemilik kost dapat segera bertindak.</p>
                </div>

                <div class="p-3.5 rounded-2xl" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                    <h4 class="font-extrabold mb-1" style="color: #581c87;">3. Mengunduh Kwitansi PDF</h4>
                    <p>Setelah status pembayaran terverifikasi <b>LUNAS</b>, Anda dapat mengunduh kwitansi resmi berbentuk file PDF melalui tabel <b>Riwayat Pembayaran & Tagihan</b>.</p>
                </div>

                <div class="p-3.5 rounded-2xl" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                    <h4 class="font-extrabold mb-1" style="color: #581c87;">4. Pengaturan Profil & Password</h4>
                    <p>Klik menu <b>Pengaturan Profile</b> di sebelah kiri untuk memperbarui informasi personal atau mengganti password akun Anda kapan saja agar tetap aman.</p>
                </div>
            </div>

            <div class="pt-2 text-right">
                <button x-on:click="$dispatch('close')" class="px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm" style="background-color: #7e22ce; color: #ffffff;">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </x-modal>
</x-app-layout>