<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KostHub') }}</title>

        <!-- Tailwind CSS CDN & Fonts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://unpkg.com/lucide@latest"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                500: '#6366f1',
                                600: '#4f46e5',
                            }
                        }
                    }
                }
            }
        </script>

        <style>
            .glass-panel {
                background: rgba(30, 41, 59, 0.7);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-100 bg-slate-950 min-h-screen antialiased flex flex-col justify-center items-center p-4 relative overflow-hidden">
        
        <!-- Glow Effect Background -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Header Branding -->
        <div class="mb-6 text-center relative z-10">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-emerald-400 p-0.5 shadow-xl mb-3">
                <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center">
                    <i data-lucide="building-2" class="w-6 h-6 text-indigo-400"></i>
                </div>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">KostHub</h1>
            <p class="text-xs text-slate-400 mt-1">Sistem Manajemen Kost Terpadu</p>
        </div>

        <!-- Auth Card Container -->
        <div class="w-full sm:max-w-md glass-panel p-8 rounded-3xl shadow-2xl relative z-10">
            {{ $slot }}
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>