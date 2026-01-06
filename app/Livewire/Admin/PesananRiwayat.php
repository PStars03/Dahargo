<?php

namespace App\Livewire\Admin;

use App\Models\Pesanan;
use Livewire\Component;
use Livewire\WithPagination;

class PesananRiwayat extends Component
{
    use WithPagination;

    public ?string $statusFilter = null;

    protected $queryString = [
        'statusFilter' => ['except' => null],
    ];

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $q = Pesanan::query()
            ->with('meja')
            ->whereIn('status', [Pesanan::STATUS_SELESAI, Pesanan::STATUS_DIBATALKAN])
            ->orderByDesc('waktu_pesan');

        $q->when(filled($this->statusFilter), fn($q) => $q->where('status', $this->statusFilter));

        $pesanan = $q->paginate(15);

        return view('livewire.admin.pesanan-riwayat', compact('pesanan'))
            ->layout('components.admin-layout');
    }
}