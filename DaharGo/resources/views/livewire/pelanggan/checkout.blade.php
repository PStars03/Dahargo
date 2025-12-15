<div class="space-y-4">
    <div class="rounded-xl border bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Checkout</h1>
            <a href="{{ route('pelanggan.menu') }}" class="text-sm font-medium text-gray-700 hover:underline">
                Kembali
            </a>
        </div>

        @error('keranjang')
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $message }}
            </div>
        @enderror

        <div class="mt-4 space-y-3">
            @foreach($daftar as $item)
                <div class="flex items-center justify-between rounded-lg border p-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $item['nama'] }}</p>
                        <p class="text-xs text-gray-500">
                            Rp {{ number_format($item['harga'], 0, ',', '.') }} × {{ $item['jumlah'] }}
                        </p>
                    </div>
                    <p class="text-sm font-semibold">
                        Rp {{ number_format($item['total_baris'], 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="mt-4 rounded-lg bg-gray-50 p-4">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-700">Subtotal</p>
                <p class="text-sm font-semibold text-gray-900">
                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold">Metode Pembayaran</h2>

        <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
            <label class="flex cursor-pointer items-center gap-3 rounded-lg border p-3">
                <input type="radio" class="text-gray-900 focus:ring-gray-900" wire:model.live="metode_pembayaran" value="tunai">
                <div>
                    <p class="text-sm font-semibold">Tunai</p>
                    <p class="text-xs text-gray-500">Bayar ke kasir/pelayan, admin akan validasi.</p>
                </div>
            </label>

            <label class="flex cursor-pointer items-center gap-3 rounded-lg border p-3">
                <input type="radio" class="text-gray-900 focus:ring-gray-900" wire:model.live="metode_pembayaran" value="transfer">
                <div>
                    <p class="text-sm font-semibold">Transfer</p>
                    <p class="text-xs text-gray-500">Upload bukti, admin akan verifikasi.</p>
                </div>
            </label>
        </div>

        <div class="mt-4 space-y-3">
            <div>
                <label class="text-sm font-medium text-gray-700">Catatan (opsional)</label>
                <textarea wire:model.defer="catatan_pelanggan"
                          class="mt-1 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900"
                          rows="3"
                          placeholder="Contoh: jangan pedas, tanpa es, dll"></textarea>
                @error('catatan_pelanggan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div x-data x-show="$wire.metode_pembayaran === 'transfer'" x-cloak class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-700">No Referensi (opsional)</label>
                    <input wire:model.defer="no_referensi"
                           class="mt-1 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900"
                           placeholder="Contoh: TRX123456" />
                    @error('no_referensi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Bukti Transfer</label>
                    <input type="file" wire:model="bukti_transfer"
                           class="mt-1 block w-full text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-gray-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-gray-800" />
                    @error('bukti_transfer') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                    <div wire:loading wire:target="bukti_transfer" class="mt-2 text-xs text-gray-500">
                        Uploading...
                    </div>
                </div>
            </div>
        </div>

        <button
            wire:click="buatPesanan"
            wire:loading.attr="disabled"
            class="mt-5 inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:cursor-not-allowed disabled:bg-gray-400"
        >
            <span wire:loading.remove wire:target="buatPesanan">Buat Pesanan</span>
            <span wire:loading wire:target="buatPesanan">Memproses...</span>
        </button>
    </div>
</div>
