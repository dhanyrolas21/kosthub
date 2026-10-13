<section>
    <header>
        <h2 class="text-base font-bold text-gray-800">
            Informasi Profil
        </h2>

        <p class="mt-1 text-xs text-gray-500">
            Perbarui informasi profil akun dan alamat email Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required style="color: #111827 !important; background-color: #ffffff !important;" class="w-full text-sm border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-xs mt-2 text-gray-800">
                        Alamat email Anda belum diverifikasi.

                        <button form="send-verification" class="underline text-xs text-blue-600 hover:text-blue-800 rounded-md focus:outline-none">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-semibold text-xs text-green-600">
                            Tautan verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
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