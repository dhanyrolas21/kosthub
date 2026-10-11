@props(['disabled' => false])

<input 
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-3 bg-slate-900/90 text-white placeholder-slate-500 border border-slate-700/80 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition font-medium'
    ]) }}
>