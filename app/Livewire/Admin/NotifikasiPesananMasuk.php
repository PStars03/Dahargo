<?php

namespace App\Livewire\Admin;

use App\Models\Pesanan;
use Livewire\Component;

class NotifikasiPesananMasuk extends Component
{
    public int $jumlah = 0;
    public bool $enablePoll = true;

    public int $lastSeenId = 0;

    public function mount(): void
    {
        $this->lastSeenId = (int) session('admin_last_seen_order_id', 0);
        $this->jumlah = $this->hitungMenunggu();
    }

    public function muat(bool $toast = true): void
    {
        $this->jumlah = $this->hitungMenunggu();

        if (!$toast) return;

        $adaBaru = Pesanan::query()
            ->where('id', '>', $this->lastSeenId)
            ->where('status', Pesanan::STATUS_MENUNGGU)
            ->count();

        if ($adaBaru > 0) {
            $this->dispatch('notyf',
                type: 'success',
                message: $adaBaru === 1 ? 'Pesanan baru masuk!' : "Ada {$adaBaru} pesanan baru!"
            );

            $this->lastSeenId = (int) (Pesanan::query()->max('id') ?? $this->lastSeenId);
            session(['admin_last_seen_order_id' => $this->lastSeenId]);
        }
    }

    private function hitungMenunggu(): int
    {
        return Pesanan::query()
            ->where('status', Pesanan::STATUS_MENUNGGU)
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.notifikasi-pesanan-masuk');
    }
}
