<div class="space-y-4">
    <div class="rounded-xl border bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold">Riwayat Pesanan</h1>
                <p class="text-sm text-gray-600">Riwayat otomatis tersimpan di perangkat ini.</p>
            </div>

            <a href="{{ route('pelanggan.menu') }}"
               class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium hover:bg-gray-50">
                Kembali ke Menu
            </a>
        </div>
    </div>

    <div class="rounded-xl border bg-white shadow-sm">
        @if($pesanan->isEmpty())
            <div class="p-6 text-sm text-gray-600">
                Belum ada pesanan.
            </div>
        @else
            <div class="divide-y">
                @foreach($pesanan as $p)
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold">
                                    {{ $p->kode }} • {{ $p->meja->nama ?? '-' }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $p->metode_pembayaran }} • {{ $p->status_pembayaran }} • {{ $p->status }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ optional($p->waktu_pesan)->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-bold">
                                    Rp {{ number_format($p->total,0,',','.') }}
                                </p>

                                <div class="mt-2 flex flex-wrap justify-end gap-2">
                                    <a href="{{ route('pelanggan.pesanan.status', ['kode' => $p->kode]) }}"
                                       class="rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-medium text-white hover:bg-gray-800">
                                        Lihat Status
                                    </a>

                                    @if($p->status_pembayaran === \App\Models\Pesanan::BAYAR_LUNAS)
                                        <a href="{{ url('/struk/'.$p->kode) }}"
                                           class="rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium hover:bg-gray-50">
                                            Struk
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-4">
                {{ $pesanan->links() }}
            </div>
        @endif
    </div>
</div>
