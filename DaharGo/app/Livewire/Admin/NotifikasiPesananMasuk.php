<?php

namespace App\Livewire\Admin;

use App\Models\Pesanan;
use Livewire\Component;

class NotifikasiPesananMasuk extends Component
{
    public int $jumlah = 0;

    public function muat(): void
    {
        $this->jumlah = Pesanan::query()
            ->where('status', Pesanan::STATUS_MENUNGGU)
            ->count();
    }

    public function mount(): void
    {
        $this->muat();
    }

    public function render()
    {
        return view('livewire.admin.notifikasi-pesanan-masuk');
    }
}
