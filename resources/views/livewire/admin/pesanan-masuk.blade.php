<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800">Pesanan Masuk</h2>
        <livewire:admin.notifikasi-pesanan-masuk />
    </div>

    <div class="mt-2 flex gap-2">
        <a href="{{ route('admin.pesanan.masuk') }}" class="rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white">Pesanan Masuk</a>
        <a href="{{ route('admin.pesanan.riwayat') }}" class="rounded-lg border px-3 py-1.5 text-sm font-semibold">Riwayat</a>
    </div>
</x-slot>

<div wire:poll.10s="muat">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="rounded-xl border bg-white shadow-sm">
            <div class="p-4 border-b">
                <p class="text-sm text-gray-600">Klik pesanan untuk verifikasi pembayaran & proses.</p>
            </div>

            <div class="divide-y">
                @forelse($pesanan as $p)
                    <div wire:key="pesanan-{{ $p->id }}" class="p-4 hover:bg-gray-50">
                        <div class="flex items-start justify-between gap-4">
                            <a href="{{ route('admin.pesanan.detail', $p->id) }}" class="block flex-1">
                                <p class="text-sm font-semibold">
                                    {{ $p->kode }} • {{ $p->meja?->nama ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $p->metode_pembayaran }} • {{ $p->status_pembayaran }} • {{ $p->status }}
                                </p>
                            </a>

                            @php
                                $bayar = $p->status_pembayaran;
                                $isLunas = $bayar === \App\Models\Pesanan::BAYAR_LUNAS;
                                $perluKonfirmasi = in_array($bayar, [
                                    \App\Models\Pesanan::BAYAR_BELUM,
                                    \App\Models\Pesanan::BAYAR_MENUNGGU_VERIF,
                                    \App\Models\Pesanan::BAYAR_DITOLAK,
                                ], true);
                            @endphp

                            <div class="mt-2 flex flex-wrap justify-end gap-2">
                                @if($perluKonfirmasi && !$isLunas)
                                    <button type="button"
                                            wire:click="setVerifikasi({{ $p->id }}, '{{ \App\Models\Pesanan::BAYAR_LUNAS }}')"
                                            class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">
                                        Terima
                                    </button>
                                    <button type="button"
                                            wire:click="setVerifikasi({{ $p->id }}, '{{ \App\Models\Pesanan::BAYAR_MENUNGGU_VERIF }}')"
                                            class="rounded-lg bg-amber-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-amber-600">
                                        Pending
                                    </button>
                                    <button type="button"
                                            wire:click="setVerifikasi({{ $p->id }}, '{{ \App\Models\Pesanan::BAYAR_DITOLAK }}')"
                                            class="rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-700">
                                        Tolak
                                    </button>
                                @elseif($isLunas)
                                    <button type="button"
                                            wire:click="setStatusPesanan({{ $p->id }}, '{{ \App\Models\Pesanan::STATUS_DIPROSES }}')"
                                            class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold hover:bg-slate-50">
                                        Sedang dibuat
                                    </button>
                                    <button type="button"
                                            wire:click="setStatusPesanan({{ $p->id }}, '{{ \App\Models\Pesanan::STATUS_SELESAI }}')"
                                            class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold hover:bg-slate-50">
                                        Selesai
                                    </button>
                                    <a href="{{ route('admin.pesanan.struk', $p->id) }}" target="_blank" rel="noopener"
                                       class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold hover:bg-slate-50">
                                        Cetak Struk
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-sm text-gray-500">Belum ada pesanan masuk.</div>
                @endforelse
            </div>

            <div class="p-4">
                {{ $pesanan->links() }}
            </div>
        </div>
    </div>
</div>
