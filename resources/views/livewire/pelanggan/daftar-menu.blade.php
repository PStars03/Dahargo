<div class="space-y-4">
    {{-- Header actions --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-semibold">Daftar Menu</h1>
            <p class="text-sm text-gray-600">Pilih menu, lalu checkout tanpa login.</p>
        </div>


    </div>

    {{-- Filter --}}
    <div class="rounded-xl border bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap gap-2">
                <button
                    wire:click="pilihKategori(0)"
                    class="rounded-full border px-3 py-1 text-sm"
                    @class([
                        'bg-gray-900 text-white border-gray-900' => $kategori_id === 0,
                        'bg-white text-gray-800 border-gray-300 hover:bg-gray-50' => $kategori_id !== 0,
                    ])
                >
                    Semua
                </button>

                @foreach($kategori as $k)
                    <button
                        wire:click="pilihKategori({{ $k->id }})"
                        class="rounded-full border px-3 py-1 text-sm"
                        @class([
                            'bg-gray-900 text-white border-gray-900' => $kategori_id === $k->id,
                            'bg-white text-gray-800 border-gray-300 hover:bg-gray-50' => $kategori_id !== $k->id,
                        ])
                    >
                        {{ $k->nama }}
                    </button>
                @endforeach
            </div>

            <div class="w-full sm:w-72">
                <input
                    wire:model.live="cari"
                    type="text"
                    placeholder="Cari menu..."
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900"
                />
            </div>
        </div>
    </div>

    {{-- Grid menu --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($menu as $m)
            <div class="rounded-xl border bg-white shadow-sm overflow-hidden flex flex-col">

                {{-- FOTO MENU --}}
                <div class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">
                    <img
                        src="{{ $m->path_foto
                            ? asset('storage/'.$m->path_foto)
                            : 'https://via.placeholder.com/400x300?text=Menu' }}"
                        alt="{{ $m->nama }}"
                        class="h-full w-full object-cover"
                    >
                </div>

                {{-- ISI CARD --}}
                <div class="flex flex-col gap-2 p-4 flex-1">

                    {{-- NAMA MENU --}}
                    <p class="text-base font-semibold text-gray-900">
                        {{ $m->nama }}
                    </p>

                    {{-- DESKRIPSI --}}
                    @if($m->deskripsi)
                        <p class="text-sm text-gray-600 line-clamp-2">
                            {{ $m->deskripsi }}
                        </p>
                    @endif

                    {{-- STOK --}}
                    @if($m->stok_tersedia <= 0)
                        <span class="mt-1 w-fit rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700">
                            Stok habis
                        </span>
                    @else
                        <span class="mt-1 w-fit rounded-full bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700">
                            Tersedia: {{ $m->stok_tersedia }}
                        </span>
                    @endif

                    {{-- FOOTER --}}
                    <div class="mt-auto flex items-center justify-between pt-3">
                        <p class="text-sm font-semibold text-gray-900">
                            Rp {{ number_format($m->harga, 0, ',', '.') }}
                        </p>

                        <button
                            wire:click="tambahKeKeranjang({{ $m->id }})"
                            @disabled($m->stok_tersedia <= 0)
                            class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium"
                            @class([
                                'bg-gray-900 text-white hover:bg-gray-800' => $m->stok_tersedia > 0,
                                'bg-gray-200 text-gray-500 cursor-not-allowed' => $m->stok_tersedia <= 0,
                            ])
                        >
                            Tambah
                        </button>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-span-full rounded-xl border bg-white p-6 text-sm text-gray-600">
                Menu tidak ditemukan.
            </div>
        @endforelse
    </div>

    <div>
        {{ $menu->links() }}
    </div>

    {{-- Drawer Keranjang --}}
    <div
        x-show="bukaKeranjang"
        x-transition.opacity
        class="fixed inset-0 z-40 bg-black/40"
        x-on:click="bukaKeranjang=false"
    ></div>

    <div
        x-show="bukaKeranjang"
        x-transition
        class="fixed right-0 top-0 z-50 h-full w-[min(92vw,420px)] bg-white shadow-xl"
        x-on:keydown.escape.window="bukaKeranjang=false"
    >
        <div class="flex items-center justify-between border-b p-4">
            <p class="text-base font-semibold">Keranjang</p>
            <button
                type="button"
                x-on:click="bukaKeranjang=false"
                class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm hover:bg-gray-50"
            >
                Tutup
            </button>
        </div>

        <div class="p-4">
            <livewire:pelanggan.keranjang-mini />
        </div>
    </div>
</div>
