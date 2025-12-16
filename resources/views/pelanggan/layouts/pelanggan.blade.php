<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $judul ?? config('app.name', 'Pemesanan Resto') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Kalau Anda memakai Livewire di halaman pelanggan, aman untuk disiapkan dari awal.
       Livewire bisa auto-inject aset, tapi jika Anda include manual, pastikan keduanya ada. :contentReference[oaicite:3]{index=3} --}}
    @livewireStyles
</head>

<body x-data="{ bukaKeranjang: false }" class="min-h-screen bg-gray-50 text-gray-900">
    <header class="border-b bg-white max-w-[825px] mx-auto rounded-md shadow-xl/30">
        <div class="mx-auto max-w-4xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-lg font-semibold leading-tight">
                        {{ config('app.name', 'Pemesanan Resto') }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Pemesanan via QR Code Meja
                    </p>
                </div>

                <div class="text-right">
                    @if(session('meja_id'))
                        <p class="text-sm font-medium">
                            Meja: {{ session('meja_nama') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            ID: {{ session('meja_id') }}
                        </p>
                    @else
                        <p class="text-sm text-gray-500">Belum memilih meja</p>
                    @endif
                </div>
                <div class="space-y-4">
                    <button type="button" x-on:click="bukaKeranjang = true" class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                            <span><i data-feather="shopping-cart"></i></span>
                            @livewire(\App\Livewire\Pelanggan\KeranjangBadge::class)
                    </button>
                </div>
            </div>
        </div>
</span>

    </header>

    <main class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8">
        @if(session('pesan'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('pesan') }}
            </div>
        @endif

        @hasSection('konten')
            @yield('konten')
        @else
            {{ $slot }}

        @endif
    </main>
{{-- Drawer Keranjang (Global) --}}
    <div
        x-show="bukaKeranjang"
        x-transition.opacity
        class="fixed inset-0 z-40 bg-black/40"
        x-on:click="bukaKeranjang=false"
        style="display:none;"
    ></div>

    <div
        x-show="bukaKeranjang"
        x-transition
        class="fixed right-0 top-0 z-50 h-full w-[min(92vw,420px)] bg-white shadow-xl"
        x-on:keydown.escape.window="bukaKeranjang=false"
        style="display:none;"
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

    @livewireScripts
</body>
</html>
