<div class="space-y-4">
    @if($jumlahItem <= 0)
        <div class="rounded-lg border border-dashed p-4 text-sm text-gray-600">
            Keranjang masih kosong.
        </div>
    @else
        <div class="space-y-3">
            @foreach($daftar as $item)
                <div class="rounded-lg border p-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $item['nama'] }}</p>
                            <p class="mt-1 text-xs text-gray-500">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                • Stok: {{ $item['stok_tersedia'] }}
                            </p>
                        </div>

                        <button
                            wire:click="hapus({{ $item['id'] }})"
                            class="rounded-md border border-gray-300 px-2 py-1 text-xs hover:bg-gray-50"
                        >
                            Hapus
                        </button>
                    </div>

                    <div class="mt-3 flex items-center justify-between">
                        <div class="inline-flex items-center gap-2">
                            <button
                                wire:click="kurang({{ $item['id'] }})"
                                class="h-9 w-9 rounded-lg border border-gray-300 text-sm hover:bg-gray-50"
                            >-</button>

                            <span class="w-8 text-center text-sm font-semibold">{{ $item['jumlah'] }}</span>

                            <button
                                wire:click="tambah({{ $item['id'] }})"
                                class="h-9 w-9 rounded-lg border border-gray-300 text-sm hover:bg-gray-50"
                            >+</button>
                        </div>

                        <p class="text-sm font-semibold text-gray-900">
                            Rp {{ number_format($item['total_baris'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="rounded-lg border bg-gray-50 p-4">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-700">Subtotal</p>
                <p class="text-sm font-semibold text-gray-900">
                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                </p>
            </div>

            <div class="mt-4 flex flex-col gap-2">
                <a
                    href="{{ url('/checkout') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                >
                    Checkout
                </a>

                <button
                    wire:click="kosongkan"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50"
                >
                    Kosongkan Keranjang
                </button>
            </div>
        </div>
    @endif
</div>
