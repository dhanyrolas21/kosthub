<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Kamar Baru</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('owner.rooms.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor Kamar</label>
                    <input type="text" name="room_number" value="{{ old('room_number') }}" required class="w-full mt-1 border rounded p-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Harga Sewa / Bulan (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}" required class="w-full mt-1 border rounded p-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status Kamar</label>
                    <select name="status" class="w-full mt-1 border rounded p-2 text-sm">
                        <option value="available">Tersedia (Available)</option>
                        <option value="occupied">Terisi (Occupied)</option>
                        <option value="maintenance">Perawatan (Maintenance)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi / Fasilitas</label>
                    <textarea name="description" rows="3" class="w-full mt-1 border rounded p-2 text-sm">{{ old('description') }}</textarea>
                </div>
                <div class="flex justify-end space-x-2 pt-4">
                    <a href="{{ route('owner.rooms.index') }}" class="px-4 py-2 border rounded text-sm text-gray-600">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-semibold hover:bg-blue-700">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>