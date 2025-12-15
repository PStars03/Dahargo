@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                QR Code Meja
            </h2>

            <button type="button"
                    onclick="window.print()"
                    class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white hover:bg-gray-800 print:hidden">
                Print
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-4 rounded-lg border border-gray-200 bg-white p-4 text-sm text-gray-600">
                Scan QR di bawah ini untuk masuk ke meja yang sesuai.
                <div class="mt-2 text-xs text-gray-500">
                    Pastikan <span class="font-mono">APP_URL</span> di <span class="font-mono">.env</span> benar agar URL QR valid.
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($daftarMeja as $meja)
                    @php
                        $urlMasuk = route('masuk.meja', $meja->token_qr);
                    @endphp

                    <div class="break-inside-avoid rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                        <div class="flex items-center justify-center">
                            {!! QrCode::size(180)->generate($urlMasuk) !!}
                        </div>

                        <div class="mt-3">
                            <div class="text-base font-semibold text-gray-900">
                                {{ $meja->nama }}
                            </div>

                            @if($meja->lokasi)
                                <div class="mt-1 text-xs text-gray-500">
                                    Lokasi: {{ $meja->lokasi }}
                                </div>
                            @endif

                            <div class="mt-2 break-all rounded bg-gray-50 p-2 font-mono text-[11px] text-gray-700">
                                {{ $urlMasuk }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 text-xs text-gray-500 print:hidden">
                Tip: jika QR tidak muncul, pastikan ekstensi PHP <span class="font-mono">ext-gd</span> aktif (dibutuhkan oleh library QR tertentu). 
            </div>
        </div>
    </div>
</x-app-layout>
