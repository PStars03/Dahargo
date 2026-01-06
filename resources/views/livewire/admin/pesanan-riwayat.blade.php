<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Pesanan</h2>
        <div></div>
    </div>

    <div class="mt-2 flex gap-2">
        <a href="{{ route('admin.pesanan.masuk') }}" class="rounded-lg border px-3 py-1.5 text-sm font-semibold">Pesanan Masuk</a>
        <a href="{{ route('admin.pesanan.riwayat') }}" class="rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white">Riwayat</a>
    </div>

    <div class="mt-3">
        <select class="w-full max-w-xs rounded-lg border-gray-300 text-sm"
                wire:model.live="statusFilter">
            <option value="">Semua status riwayat</option>
            <option value="{{ \App\Models\Pesanan::STATUS_SELESAI }}">Selesai</option>
            <option value="{{ \App\Models\Pesanan::STATUS_DIBATALKAN }}">Dibatalkan</option>
        </select>
    </div>
</x-slot>

<div>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="rounded-xl border bg-white shadow-sm">
            <div class="p-4 border-b">
                <p class="text-sm text-gray-600">Pesanan yang sudah selesai / dibatalkan.</p>
            </div>

            <div class="divide-y">
                @forelse($pesanan as $p)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-start justify-between gap-4">
                            <a href="{{ route('admin.pesanan.detail', $p->id) }}" class="block flex-1">
                                <p class="text-sm font-semibold">
                                    {{ $p->kode }} • {{ $p->meja?->nama ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $p->metode_pembayaran }} • {{ $p->status_pembayaran }} • {{ $p->status }}
                                </p>
                            </a>

                            <div class="mt-2 flex flex-wrap justify-end gap-2">
                                <a href="{{ route('admin.pesanan.struk', $p->id) }}" target="_blank" rel="noopener"
                                   class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold hover:bg-slate-50">
                                    Cetak Struk
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-sm text-gray-500">Belum ada riwayat pesanan.</div>
                @endforelse
            </div>

            <div class="p-4">
                {{ $pesanan->links() }}
            </div>
        </div>
    </div>
</div>
