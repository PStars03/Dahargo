<?php

namespace App\Livewire\Admin;

use App\Models\Pesanan;
use App\Services\StokService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailPesanan extends Component
{
    public Pesanan $pesanan;

    public function mount(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan->load(['meja', 'item', 'pembayaran']);
    }

    public function muat(): void
    {
        $this->pesanan->refresh()->load(['meja', 'item', 'pembayaran']);
    }

    public function verifikasiDanProses(StokService $stokService): void
    {
        DB::transaction(function () use ($stokService) {
            $p = Pesanan::query()->whereKey($this->pesanan->id)->lockForUpdate()->firstOrFail();
            $p->load(['item', 'pembayaran']);

            // set pembayaran terverifikasi + pesanan lunas
            if ($p->pembayaran) {
                $p->pembayaran->status = 'terverifikasi';
                $p->pembayaran->diverifikasi_oleh = auth()->id();
                $p->pembayaran->waktu_verifikasi = now();
                $p->pembayaran->save();
            }

            $p->status_pembayaran = Pesanan::BAYAR_LUNAS;
            $p->status = Pesanan::STATUS_DIKONFIRMASI;
            $p->waktu_validasi = now();
            $p->save();

            // KOMIT STOK (stok_fisik turun & stok_dipesan turun)
            $stokService->komitTerjual($p, auth()->id());
        });

        $this->dispatch('toast', tipe: 'sukses', pesan: 'Pembayaran diverifikasi & stok dikomit.');
        $this->muat();
    }

    public function tolakPembayaran(StokService $stokService): void
    {
        DB::transaction(function () use ($stokService) {
            $p = Pesanan::query()->whereKey($this->pesanan->id)->lockForUpdate()->firstOrFail();
            $p->load(['item', 'pembayaran']);

            if ($p->pembayaran) {
                $p->pembayaran->status = 'ditolak';
                $p->pembayaran->diverifikasi_oleh = auth()->id();
                $p->pembayaran->waktu_verifikasi = now();
                $p->pembayaran->save();
            }

            $p->status_pembayaran = Pesanan::BAYAR_DITOLAK;
            $p->status = Pesanan::STATUS_DIBATALKAN;
            $p->waktu_validasi = now();
            $p->save();

            // lepas reservasi karena ditolak
            $stokService->lepasReservasi($p, auth()->id());
        });

        $this->dispatch('toast', tipe: 'info', pesan: 'Pembayaran ditolak, reservasi stok dilepas.');
        $this->muat();
    }

    public function render()
    {
        return view('livewire.admin.detail-pesanan');
    }
}