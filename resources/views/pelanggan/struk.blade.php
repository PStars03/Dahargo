@extends('pelanggan.layouts.pelanggan', ['judul' => 'Struk'])

@section('konten')
<div class="space-y-4">
    <div class="rounded-xl border bg-white p-6 shadow-sm print:shadow-none print:border-0">
        <div class="flex items-center justify-between gap-3 print:hidden">
            <a href="{{ route('pelanggan.riwayat') }}"
               class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium hover:bg-gray-50">
                Kembali
            </a>
            <button onclick="window.print()"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                Print
            </button>
        </div>

        <div class="mt-4 text-center">
            <p class="text-lg font-bold">{{ config('app.name', 'Pemesanan Resto') }}</p>
            <p class="text-sm text-gray-600">Struk Pembelian</p>
        </div>

        <div class="mt-4 rounded-lg border bg-gray-50 p-4">
            <p class="text-sm"><span class="text-gray-600">Kode:</span> <span class="font-mono font-semibold">{{ $pesanan->kode }}</span></p>
            <p class="text-sm"><span class="text-gray-600">Meja:</span> <span class="font-semibold">{{ $pesanan->meja->nama ?? '-' }}</span></p>
            <p class="text-sm"><span class="text-gray-600">Waktu:</span> {{ optional($pesanan->waktu_validasi ?? $pesanan->waktu_pesan)->format('d/m/Y H:i') }}</p>
        </div>

        <div class="mt-4 space-y-2">
            @foreach($pesanan->item as $it)
                <div class="flex items-start justify-between">
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

        <div class="mt-4 rounded-lg bg-gray-50 p-4">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-700">Total</p>
                <p class="text-sm font-bold text-gray-900">
                    Rp {{ number_format($pesanan->total,0,',','.') }}
                </p>
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Metode: {{ $pesanan->metode_pembayaran }}
            </p>
        </div>

        <p class="mt-6 text-center text-xs text-gray-500">
            Terima kasih 🙏
        </p>
    </div>
</div>
@endsection
