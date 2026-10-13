<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-lg text-gray-800">
                Tambah Penghuni Baru
            </h2>
            <a href="{{ route('owner.tenants.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-bold rounded-xl transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="p-6 sm:p-8 rounded-3xl shadow-sm" style="background-color: #ffffff; border: 1px solid #e9d5ff;">
            <div class="pb-4 mb-6" style="border-bottom: 2px solid #f3e8ff;">
                <h3 class="text-base font-black text-gray-900">Form Pendaftaran Penghuni</h3>
                <p class="text-xs text-gray-500 mt-1">Masukkan data lengkap penghuni baru. Akun login dan tagihan bulan pertama akan otomatis diterbitkan oleh sistem.</p>
            </div>

            <form action="{{ route('owner.tenants.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-black uppercase tracking-wider mb-2" style="color: #581c87;">Nama Lengkap Penghuni</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso" style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-xl p-3 focus:ring-purple-500 focus:border-purple-500">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-black uppercase tracking-wider mb-2" style="color: #581c87;">Alamat Email (Untuk Login)</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="budi@gmail.com" style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-xl p-3 focus:ring-purple-500 focus:border-purple-500">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon / HP -->
                <div>
                    <label for="phone" class="block text-xs font-black uppercase tracking-wider mb-2" style="color: #581c87;">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="081234567890" style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-xl p-3 focus:ring-purple-500 focus:border-purple-500">
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai Sewa -->
                <div>
                    <label for="start_date" class="block text-xs font-black uppercase tracking-wider mb-2" style="color: #581c87;">Tanggal Mulai Sewa</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-xl p-3 focus:ring-purple-500 focus:border-purple-500">
                    @error('start_date')
                        <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilih Kamar -->
                <div>
                    <label for="room_id" class="block text-xs font-black uppercase tracking-wider mb-2" style="color: #581c87;">Pilih Kamar (Yang Kosong)</label>
                    <select name="room_id" id="room_id" required style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-xl p-3 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($availableRooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                Kamar {{ $room->room_number }} (Rp {{ number_format($room->price, 0, ',', '.') }} / bulan)
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan Password bawaan -->
                <div class="p-4 rounded-2xl border" style="background-color: #faf5ff; border-color: #e9d5ff;">
                    <p class="text-xs font-bold text-purple-900">🔑 Catatan Akses Login:</p>
                    <p class="text-xs text-gray-600 mt-0.5">Password bawaan akun untuk penghuni baru adalah <span class="font-black text-purple-700 bg-purple-100 px-2 py-0.5 rounded">password</span>. Penghuni dapat mengubah password setelah login melalui menu Pengaturan Profil.</p>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('owner.tenants.index') }}" class="px-5 py-3 rounded-xl text-xs font-bold transition" style="background-color: #f3e8ff; color: #581c87;">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl text-xs font-black transition shadow-md" style="background-color: #7e22ce; color: #ffffff;">
                        Simpan & Daftarkan Penghuni
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>