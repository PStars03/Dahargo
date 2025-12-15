<div wire:poll.5s="muat">
    <a href="{{ route('admin.pesanan.index') }}"
       class="relative inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium hover:bg-gray-50">
        Pesanan Masuk
        @if($jumlah > 0)
            <span class="ml-2 rounded-full bg-red-600 px-2 py-0.5 text-xs font-semibold text-white">
                {{ $jumlah }}
            </span>
        @endif
    </a>
</div>
