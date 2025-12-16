<?php

namespace App\Livewire\Admin;

use App\Models\Pesanan;
use Livewire\Component;

class NotifikasiPesananMasuk extends Component
{
    public int $jumlah = 0;
    public int $sebelumnya = 0;
    public bool $enablePoll = true;

    public function muat(bool $toast = false): void
    {
        $baru = Pesanan::query()
            ->where('status', Pesanan::STATUS_MENUNGGU)
            ->count();

        if ($toast && $baru > $this->jumlah) {
            $selisih = $baru - $this->jumlah;
            $this->dispatch('notyf',
                type: 'success',
                message: $selisih === 1
                    ? 'Pesanan baru masuk!'
                    : "{$selisih} pesanan baru masuk!"
            );
        }

        $this->jumlah = $baru;
    }

    public function mount(): void
    {
        $this->muat(false);
    }

    public function render()
    {
        return view('livewire.admin.notifikasi-pesanan-masuk');
    }
}