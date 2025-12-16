
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Antrian Pesanan</h2>
            <livewire:admin.notifikasi-pesanan-masuk />
        </div>
        <div class="flex items-center justify-between">
            <span class="text-xs text-gray-500">Auto refresh</span>
        </div>
    </x-slot>

    <div wire:poll.5s.visible="muat">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-xl border bg-white shadow-sm">
                <div class="p-4 border-b">
                    <p class="text-sm text-gray-600">Klik pesanan untuk verifikasi pembayaran & proses.</p>
                </div>

                <div class="divide-y">
                    @foreach($pesanan as $p)
                    <div wire:key="pesanan-{{ $p->id }}">
                        <a href="{{ route('admin.pesanan.detail', $p->id) }}"
                           class="block p-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold">
                                        {{ $p->kode }} • {{ $p->meja->nama ?? '-' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $p->metode_pembayaran }} • {{ $p->status_pembayaran }} • {{ $p->status }}
                                    </p>
                                    @if(filled($p->catatan_pelanggan))
                                        <p class="mt-1 text-xs text-yellow-700">
                                            Catatan: {{ \Illuminate\Support\Str::limit($p->catatan_pelanggan, 40) }}
                                        </p>
                                    @endif
                                </div>
                                <p class="text-sm font-bold">
                                    Rp {{ number_format($p->total,0,',','.') }}
                                </p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="p-4">
                    {{ $pesanan->links() }}
                </div>
            </div>
        </div>
    </div>
