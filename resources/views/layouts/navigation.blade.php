<nav x-data="{ open: false }" class="bg-transparent">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        
        <!-- Navigation Links (Kapsul Melayang / Pill Nav) -->
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

        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center">
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