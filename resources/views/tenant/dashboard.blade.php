<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Penghuni</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif

        @if($activeInvoice)
            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="font-bold text-lg mb-2">Tagihan Aktif Periode {{ $activeInvoice->period_month }}/{{ $activeInvoice->period_year }}</h3>
                <p class="text-2xl font-extrabold text-blue-600 mb-2">Rp {{ number_format($activeInvoice->amount, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600 mb-4">Jatuh Tempo: {{ $activeInvoice->due_date }}</p>

                <div class="mb-4">
                    Status Tagihan: 
                    <span class="px-2 py-1 rounded text-xs font-bold {{ $activeInvoice->status === 'paid' ? 'bg-green-200 text-green-800' : ($activeInvoice->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                        {{ strtoupper($activeInvoice->status) }}
                    </span>
                </div>

                @if($activeInvoice->status !== 'paid')
                    <form action="{{ route('tenant.invoices.pay', $activeInvoice->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 border-t pt-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Bukti Transfer</label>
                            <input type="file" name="proof_image" required class="w-full text-sm border p-2 rounded">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                @endif
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                Belum ada tagihan aktif.
            </div>
        @endif
    </div>
</x-app-layout>