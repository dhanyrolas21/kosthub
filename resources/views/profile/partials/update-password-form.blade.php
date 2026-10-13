<section>
    <header>
        <h2 class="text-base font-bold text-gray-800">
            Perbarui Password
        </h2>

        <p class="mt-1 text-xs text-gray-500">
            Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-bold text-gray-700 uppercase mb-1">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" required style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-bold text-gray-700 uppercase mb-1">Password Baru</label>
            <input id="update_password_password" name="password" type="password" required style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-bold text-gray-700 uppercase mb-1">Konfirmasi Password Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" required style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition">
                Simpan
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-green-600 font-semibold"
                >Tersimpan.</p>
            @endif
        </div>
    </form>
</section>