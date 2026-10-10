<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pendaftaran Penghuni Baru</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow border">
            <form action="{{ route('owner.tenants.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full mt-1 border border-gray-300 rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email (Untuk Login)</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full mt-1 border border-gray-300 rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor Telepon / WA</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full mt-1 border border-gray-300 rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kamar Kosong</label>
                    <select name="room_id" required class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Kamar --</option>
                        
                        {{-- Tipe Biasa (Kamar 1 - 5) --}}
                        @php
                            $biasa = $availableRooms->filter(fn($r) => (int)$r->room_number >= 1 && (int)$r->room_number <= 5);
                        @endphp
                        @if($biasa->isNotEmpty())
                            <optgroup label="Tipe Biasa (Kamar 1-5)">
                                @foreach($biasa as $room)
                                    <option value="{{ $room->id }}">Kamar {{ $room->room_number }} (Rp {{ number_format($room->price, 0, ',', '.') }}/bln)</option>
                                @endforeach
                            </optgroup>
                        @endif

                        {{-- Tipe Eksklusif (Kamar 6 - 10) --}}
                        @php
                            $eksklusif = $availableRooms->filter(fn($r) => (int)$r->room_number >= 6 && (int)$r->room_number <= 10);
                        @endphp
                        @if($eksklusif->isNotEmpty())
                            <optgroup label="Tipe Eksklusif (Kamar 6-10)">
                                @foreach($eksklusif as $room)
                                    <option value="{{ $room->id }}">Kamar {{ $room->room_number }} (Rp {{ number_format($room->price, 0, ',', '.') }}/bln)</option>
                                @endforeach
                            </optgroup>
                        @endif

                        {{-- Tipe VIP (Kamar 11 - 15) --}}
                        @php
                            $vip = $availableRooms->filter(fn($r) => (int)$r->room_number >= 11 && (int)$r->room_number <= 15);
                        @endphp
                        @if($vip->isNotEmpty())
                            <optgroup label="Tipe VIP (Kamar 11-15)">
                                @foreach($vip as $room)
                                    <option value="{{ $room->id }}">Kamar {{ $room->room_number }} (Rp {{ number_format($room->price, 0, ',', '.') }}/bln)</option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai Sewa</label>
                    <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required class="w-full mt-1 border border-gray-300 rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex justify-end space-x-2 pt-4">
                    <a href="{{ route('owner.tenants.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Daftarkan Penghuni</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>