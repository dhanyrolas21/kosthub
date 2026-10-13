<nav x-data="{ open: false }" class="bg-transparent">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        
        <!-- Navigation Links (Kapsul Melayang) -->
        <div class="hidden sm:flex items-center space-x-1.5 bg-slate-950/80 p-1.5 rounded-2xl border border-slate-800 shadow-inner">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                {{ __('Dashboard') }}
            </x-nav-link>

            @if(Auth::user()->role === 'owner')
                <x-nav-link :href="route('owner.rooms.index')" :active="request()->routeIs('owner.rooms.*')" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 {{ request()->routeIs('owner.rooms.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                    {{ __('Manajemen Kamar') }}
                </x-nav-link>

                <x-nav-link :href="route('owner.tenants.index')" :active="request()->routeIs('owner.tenants.*')" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 {{ request()->routeIs('owner.tenants.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                    {{ __('Manajemen Penghuni') }}
                </x-nav-link>

                <x-nav-link :href="route('owner.payments.index')" :active="request()->routeIs('owner.payments.*')" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 {{ request()->routeIs('owner.payments.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                    {{ __('Verifikasi Pembayaran') }}
                </x-nav-link>

                <x-nav-link :href="route('owner.complaints.index')" :active="request()->routeIs('owner.complaints.*')" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 {{ request()->routeIs('owner.complaints.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                    {{ __('Laporan Kerusakan') }}
                </x-nav-link>
            @else
                <x-nav-link :href="route('tenant.complaints.index')" :active="request()->routeIs('tenant.complaints.*')" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 {{ request()->routeIs('tenant.complaints.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                    {{ __('Laporan Kerusakan') }}
                </x-nav-link>
            @endif
        </div>

        <!-- Right Side Controls: Mode Switcher, Date, & Profile -->
        <div class="hidden sm:flex sm:items-center space-x-3">
            
            <!-- Tombol Switch Dark/Light Mode -->
            <button 
                id="theme-toggle" 
                type="button" 
                class="p-2 rounded-xl transition flex items-center justify-center shadow-sm cursor-pointer"
                style="background-color: #f3e8ff; color: #581c87; border: 1px solid #e9d5ff;"
                title="Beralih Mode Gelap/Terang"
            >
                <svg id="theme-toggle-light-icon" class="hidden w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
                <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4 text-purple-700" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
            </button>

            <!-- Widget Tanggal -->
            <div class="px-3.5 py-2 rounded-xl text-xs font-bold shadow-sm" style="background-color: #f3e8ff; color: #581c87; border: 1px solid #e9d5ff;">
                {{ now()->format('d M Y') }}
            </div>

            <!-- Profile Dropdown -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center space-x-2 px-3.5 py-2 border border-slate-800 rounded-xl text-xs font-bold text-slate-300 bg-slate-900 hover:text-white hover:bg-slate-800 transition">
                        <div class="w-5 h-5 rounded-full bg-brand-500/20 text-brand-300 flex items-center justify-center text-[10px]">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>{{ Auth::user()->name }}</div>
                        <svg class="fill-current h-4 w-4 text-slate-400" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-2xl">
                        <x-dropdown-link :href="route('profile.edit')" class="text-xs text-slate-300 hover:bg-slate-800 hover:text-white">
                            {{ __('Profile Saya') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="text-xs text-rose-400 hover:bg-rose-500/10">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Hamburger (Mobile) -->
        <div class="-mr-2 flex items-center sm:hidden">
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden mt-3 bg-slate-900 border border-slate-800 rounded-2xl p-4 space-y-2">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-300 hover:text-white">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-400">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </form>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            if(lightIcon) lightIcon.classList.remove('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            if(darkIcon) darkIcon.classList.remove('hidden');
        }

        if(themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function() {
                darkIcon.classList.toggle('hidden');
                lightIcon.classList.toggle('hidden');

                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        }
    });
</script>