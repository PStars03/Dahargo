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

<body class="min-h-screen bg-gray-50 text-gray-900">
    <header class="border-b bg-white">
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
            </div>
        </div>
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

    @livewireScripts
</body>
</html>
