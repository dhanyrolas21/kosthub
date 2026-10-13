<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KostHub') }}</title>

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body, button, input, select, textarea {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
    </style>

    <!-- Inisialisasi Mode Sebelum Page Rendering -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="antialiased bg-[#f3f0ff] dark:bg-slate-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">
    <div class="min-h-screen flex">
        
        <!-- SIDEBAR KIRI -->
        <aside class="w-64 flex flex-col justify-between shrink-0 min-h-screen shadow-2xl transition-colors duration-300 bg-[#3b0764] dark:bg-slate-950 text-white">
            <div>
                <!-- Brand / Logo -->
                <div class="p-6 flex items-center gap-3 border-b border-white/10">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xl bg-white/15 text-white">
                        K
                    </div>
                    <div>
                        <h1 class="text-xl font-black tracking-wider leading-none text-white">KostHub</h1>
                        <span class="text-xs font-bold uppercase tracking-widest text-purple-300">Management</span>
                    </div>
                </div>

                <!-- User Profile Brief Sidebar -->
                <div class="p-4 mx-4 my-4 rounded-2xl flex items-center gap-3 bg-black/25 border border-white/10">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-base font-black shrink-0 bg-purple-700 text-white">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-extrabold truncate text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs font-bold uppercase text-purple-200">{{ Auth::user()->role === 'owner' ? 'Pemilik Kost' : 'Penghuni' }}</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="px-4 space-y-2 font-bold text-sm">
                    <p class="px-3 text-xs uppercase tracking-wider font-extrabold mb-2 text-purple-300">Menu Utama</p>

                    @if(Auth::user()->role === 'owner')
                        <!-- Menu Pemilik Kost -->
                        <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('owner.dashboard') ? 'bg-purple-800 text-white' : 'text-purple-200 hover:bg-purple-900/50' }}">
                            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('owner.rooms.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('owner.rooms*') ? 'bg-purple-800 text-white' : 'text-purple-200 hover:bg-purple-900/50' }}">
                            <i data-lucide="door-open" class="w-5 h-5"></i>
                            <span>Manajemen Kamar</span>
                        </a>
                        <a href="{{ route('owner.tenants.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('owner.tenants*') ? 'bg-purple-800 text-white' : 'text-purple-200 hover:bg-purple-900/50' }}">
                            <i data-lucide="users" class="w-5 h-5"></i>
                            <span>Manajemen Penghuni</span>
                        </a>
                        <a href="{{ route('owner.payments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('owner.payments*') ? 'bg-purple-800 text-white' : 'text-purple-200 hover:bg-purple-900/50' }}">
                            <i data-lucide="wallet" class="w-5 h-5"></i>
                            <span>Verifikasi Pembayaran</span>
                        </a>
                        <a href="{{ route('owner.complaints.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('owner.complaints*') ? 'bg-purple-800 text-white' : 'text-purple-200 hover:bg-purple-900/50' }}">
                            <i data-lucide="alert-circle" class="w-5 h-5"></i>
                            <span>Laporan Kerusakan</span>
                        </a>
                    @else
                        <!-- Menu Penghuni Kost -->
                        <a href="{{ route('tenant.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('tenant.dashboard') ? 'bg-purple-800 text-white' : 'text-purple-200 hover:bg-purple-900/50' }}">
                            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('tenant.complaints.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('tenant.complaints*') ? 'bg-purple-800 text-white' : 'text-purple-200 hover:bg-purple-900/50' }}">
                            <i data-lucide="wrench" class="w-5 h-5"></i>
                            <span>Laporan Kerusakan</span>
                        </a>
                    @endif

                    <p class="px-3 text-xs uppercase tracking-wider font-extrabold pt-5 mb-2 text-purple-300">Akun Saya</p>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('profile.edit') ? 'bg-purple-800 text-white' : 'text-purple-200 hover:bg-purple-900/50' }}">
                        <i data-lucide="user-cog" class="w-5 h-5"></i>
                        <span>Pengaturan Profile</span>
                    </a>
                </nav>
            </div>

            <!-- Logout Bottom Button -->
            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-extrabold text-sm text-red-300 bg-red-500/15 hover:bg-red-500/25 transition cursor-pointer">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#f3f0ff] dark:bg-slate-900 transition-colors duration-300">
            <!-- Top Navbar Minimalis -->
            <header class="px-8 py-5 flex items-center justify-between shadow-sm bg-white dark:bg-slate-800 border-b border-[#e9d5ff] dark:border-slate-700 transition-colors duration-300">
                <h2 class="font-black text-lg text-gray-800 dark:text-white">
                    {{ $header ?? 'Dashboard System' }}
                </h2>
                
                <!-- Right Controls: Toggle Dual Mode Mencolok + Widget Tanggal -->
                <div class="flex items-center gap-3">
                    
                    <!-- Tombol Dual Switch Super Mencolok: ☀️ / 🌙 -->
                    <button 
                        id="theme-toggle" 
                        type="button" 
                        class="p-1 rounded-2xl transition flex items-center gap-1 shadow-md cursor-pointer border-2 bg-amber-100 border-amber-400 dark:bg-purple-950 dark:border-purple-600 hover:scale-105 active:scale-95"
                        title="Klik untuk Beralih Mode Terang / Gelap"
                    >
                        <!-- Kapsul Matahari (Light Indicator) -->
                        <div id="sun-box" class="px-2.5 py-1 rounded-xl flex items-center gap-1 transition-all duration-300 bg-amber-400 text-amber-950 shadow-sm font-black text-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <!-- Pembatas Garis Miring -->
                        <span class="text-xs font-black text-amber-700 dark:text-purple-300 px-0.5 select-none">/</span>

                        <!-- Kapsul Bulan (Dark Indicator) -->
                        <div id="moon-box" class="px-2.5 py-1 rounded-xl flex items-center gap-1 transition-all duration-300 opacity-40 text-purple-700 dark:text-purple-200 font-black text-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- Widget Tanggal -->
                    <span class="text-sm font-extrabold px-4 py-2 rounded-2xl bg-purple-100 dark:bg-slate-700 text-purple-900 dark:text-purple-200 border border-purple-200 dark:border-slate-600 shadow-sm">
                        {{ \Carbon\Carbon::now()->format('d M Y') }}
                    </span>
                </div>
            </header>

            <!-- Page Content View -->
            <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>

    </div>

    <!-- Script Switcher Efek Menyala Mencolok -->
    <script>
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const sunBox = document.getElementById('sun-box');
            const moonBox = document.getElementById('moon-box');

            function updateToggleStyle() {
                if (document.documentElement.classList.contains('dark')) {
                    // Mode Gelap: Kapsul Bulan Menyala Terang Pekat
                    moonBox.className = "px-2.5 py-1 rounded-xl flex items-center gap-1 transition-all duration-300 bg-purple-600 text-white shadow-md font-black text-xs opacity-100 scale-105";
                    sunBox.className = "px-2.5 py-1 rounded-xl flex items-center gap-1 transition-all duration-300 opacity-30 text-amber-400 font-black text-xs scale-90";
                } else {
                    // Mode Terang: Kapsul Matahari Menyala Emas Terang
                    sunBox.className = "px-2.5 py-1 rounded-xl flex items-center gap-1 transition-all duration-300 bg-amber-400 text-amber-950 shadow-md font-black text-xs opacity-100 scale-105";
                    moonBox.className = "px-2.5 py-1 rounded-xl flex items-center gap-1 transition-all duration-300 opacity-40 text-purple-800 font-black text-xs scale-90";
                }
            }

            updateToggleStyle();

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    document.documentElement.classList.toggle('dark');
                    if (document.documentElement.classList.contains('dark')) {
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        localStorage.setItem('color-theme', 'light');
                    }
                    updateToggleStyle();
                });
            }
        });
    </script>
</body>
</html>