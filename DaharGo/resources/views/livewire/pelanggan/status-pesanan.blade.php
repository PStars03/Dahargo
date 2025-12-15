<div wire:poll.5s class="space-y-4">
    <div class="rounded-xl border bg-white p-6 shadow-sm">
        <h1 class="text-xl font-semibold">Status Pesanan</h1>
        <p class="mt-1 text-sm text-gray-600">
            Kode: <span class="font-mono font-semibold">{{ $pesanan->kode }}</span>
        </p>

        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div class="rounded-lg border p-4">
                <p class="text-sm text-gray-500">Status Pesanan</p>
                <p class="mt-1 text-base font-semibold">{{ $pesanan->status }}</p>
            </div>
            <div class="rounded-lg border p-4">
                <p class="text-sm text-gray-500">Status Pembayaran</p>
                <p class="mt-1 text-base font-semibold">{{ $pesanan->status_pembayaran }}</p>
            </div>
        </div>

        <div class="mt-4 rounded-lg bg-gray-50 p-4">
            <p class="text-sm text-gray-700">Total</p>
            <p class="mt-1 text-lg font-semibold">
                Rp {{ number_format($pesanan->total, 0, ',', '.') }}
            </p>
            <p class="mt-1 text-xs text-gray-500">
                Metode: {{ $pesanan->metode_pembayaran }}
            </p>
        </div>

        @if($pesanan->status_pembayaran === 'lunas')
            <a href="{{ route('pelanggan.struk', ['kode' => $pesanan->kode]) }}"
               class="mt-4 inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                Lihat Struk
            </a>
        @else
            <div class="mt-4 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                Menunggu validasi admin. Halaman ini akan otomatis update.
            </div>
        @endif
    </div>

    <div class="rounded-xl border bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold">Rincian Item</h2>
        <div class="mt-3 space-y-2">
            @foreach($pesanan->item as $it)
                <div class="flex items-center justify-between rounded-lg border p-3">
                    <div>
                        <p class="text-sm font-semibold">{{ $it->nama_menu_snapshot }}</p>
                        <p class="text-xs text-gray-500">
                            Rp {{ number_format($it->harga_snapshot, 0, ',', '.') }} × {{ $it->jumlah }}
                        </p>
                    </div>
                    <p class="text-sm font-semibold">
                        Rp {{ number_format($it->total_baris, 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>
