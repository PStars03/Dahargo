@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Meja</h2>
        </div>
        <livewire:admin.meja-crud />
    </x-slot>
</x-admin-layout>
