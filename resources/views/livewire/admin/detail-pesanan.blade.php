<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Antrian Pesanan</h2>
            <livewire:admin.notifikasi-pesanan-masuk />
        </div>
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Detail Pesanan</h2>
            <a href="{{ route('admin.pesanan.index') }}"
               class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-4">
            <div class="rounded-xl border bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Kode</p>
                        <p class="text-lg font-semibold">{{ $pesanan->kode }}</p>
                        <p class="mt-1 text-sm text-gray-600">
                            Meja: <b>{{ $pesanan->meja->nama ?? '-' }}</b>
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $pesanan->metode_pembayaran }} • {{ $pesanan->status_pembayaran }} • {{ $pesanan->status }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="text-lg font-bold">Rp {{ number_format($pesanan->total,0,',','.') }}</p>
                    </div>
                </div>

                @if($pesanan->pembayaran?->path_bukti)
                    <div class="mt-4">
                        <p class="text-sm font-medium">Bukti Transfer</p>
                        <a class="text-sm text-blue-600 underline"
                           href="{{ asset('storage/'.$pesanan->pembayaran->path_bukti) }}" target="_blank">
                            Lihat Bukti
                        </a>
                    </div>
                @endif
            </div>

            <div class="rounded-xl border bg-white p-6 shadow-sm">
                <h3 class="text-base font-semibold">Item</h3>

                <div class="mt-4 space-y-3">
                    @foreach($pesanan->item as $it)
                        <div class="flex items-start justify-between gap-4 rounded-lg border p-4">
                            <div>
                                <p class="text-sm font-semibold">{{ $it->nama_menu_snapshot }}</p>
                                <p class="text-xs text-gray-500">
                                    Rp {{ number_format($it->harga_snapshot,0,',','.') }} × {{ $it->jumlah }}
                                </p>
                            </div>
                            <p class="text-sm font-semibold">
                                Rp {{ number_format($it->total_baris,0,',','.') }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 flex flex-col gap-2 sm:flex-row">
                    <button
                        wire:click="verifikasiDanProses"
                        class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                    >
                        Verifikasi / Tandai Lunas
                    </button>

                    <button
                        wire:click="tolakPembayaran"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium hover:bg-gray-50"
                    >
                        Tolak / Batalkan
                    </button>
                </div>

                <p class="mt-3 text-xs text-gray-500">
                    Tombol “Verifikasi” akan <b>komit stok</b> (stok_fisik turun & stok_dipesan turun) + membuat mutasi_stok.
                </p>
            </div>
        </div>
    </div>
</x-admin-layout>
