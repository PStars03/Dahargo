<?php

namespace App\Livewire\Admin;

use App\Models\Pesanan;
use App\Services\StokService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AntrianPesanan extends Component
{
    use WithPagination;

    public function batalkan(int $pesananId): void
    {
        DB::transaction(function () use ($pesananId) {
            $p = Pesanan::query()->whereKey($pesananId)->lockForUpdate()->firstOrFail();
            $p->load('item');

            if ($p->status !== Pesanan::STATUS_MENUNGGU) {
                return;
            }

            // lepas reservasi stok
            app(StokService::class)->lepasReservasi($p, auth()->id());

            $p->status = Pesanan::STATUS_DIBATALKAN;
            $p->status_pembayaran = Pesanan::BAYAR_DIBATALKAN;
            $p->waktu_validasi = now();
            $p->save();
        });

        session()->flash('pesan_sukses', 'Pesanan dibatalkan & reservasi stok dilepas.');
    }

    public function render()
    {
        $pesanan = Pesanan::query()
            ->with('meja')
            ->orderByDesc('waktu_pesan')
            ->paginate(15);

        return view('livewire.admin.antrian-pesanan', compact('pesanan'));
    }
}
