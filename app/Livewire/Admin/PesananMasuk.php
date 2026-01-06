<?php

namespace App\Livewire\Admin;

use App\Models\Pesanan;
use App\Services\StokService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PesananMasuk extends Component
{
    use WithPagination;

    public function muat(): void
    {
        $this->dispatch('$refresh');
    }

    public function batalkan(int $pesananId): void
    {
        DB::transaction(function () use ($pesananId) {
            $p = Pesanan::query()->whereKey($pesananId)->lockForUpdate()->firstOrFail();
            $p->load('item');

            if ($p->status !== Pesanan::STATUS_MENUNGGU) return;

            app(StokService::class)->lepasReservasi($p, auth()->id());

            $p->status = Pesanan::STATUS_DIBATALKAN;
            $p->status_pembayaran = Pesanan::BAYAR_DITOLAK;
            $p->waktu_validasi = now();
            $p->save();
        });

        session()->flash('notyf', ['type' => 'warning', 'message' => 'Pesanan dibatalkan & reservasi stok dilepas.']);
        $this->resetPage();
    }

    public function setVerifikasi(int $pesananId, string $status): void
    {
        if (!in_array($status, [
            Pesanan::BAYAR_LUNAS,
            Pesanan::BAYAR_MENUNGGU_VERIF,
            Pesanan::BAYAR_DITOLAK,
        ], true)) return;

        try {
            DB::transaction(function () use ($pesananId, $status) {
                $p = Pesanan::query()
                    ->with('pembayaran')
                    ->lockForUpdate()
                    ->findOrFail($pesananId);

                $p->status_pembayaran = $status;
                $p->waktu_validasi = $status === Pesanan::BAYAR_LUNAS ? now() : null;

                if ($p->pembayaran) {
                    $p->pembayaran->diverifikasi_oleh = Auth::id();
                    $p->pembayaran->waktu_verifikasi = $status === Pesanan::BAYAR_LUNAS ? now() : null;
                    $p->pembayaran->save();
                }

                if ($status === Pesanan::BAYAR_LUNAS && $p->status === Pesanan::STATUS_MENUNGGU) {
                    $p->status = Pesanan::STATUS_DIPROSES;
                }

                $p->save();
            });

            $this->dispatch('notyf', type: 'success', message: 'Pembayaran berhasil diverifikasi');
            $this->resetPage();
        } catch (\Throwable $e) {
            $this->dispatch('notyf', type: 'error', message: $e->getMessage());
        }
    }

    public function setStatusPesanan(int $pesananId, string $status): void
    {
        if (!in_array($status, [Pesanan::STATUS_DIPROSES, Pesanan::STATUS_SELESAI], true)) return;

        try {
            DB::transaction(function () use ($pesananId, $status) {
                $p = Pesanan::query()->lockForUpdate()->findOrFail($pesananId);

                $boleh = $p->status_pembayaran === Pesanan::BAYAR_LUNAS || $p->metode_pembayaran === 'tunai';
                if (!$boleh) throw new \RuntimeException('Pembayaran belum lunas');

                $p->status = $status;
                $p->save();
            });

            $this->dispatch('notyf', type: 'success', message: 'Status pesanan diperbarui');

            // ✅ selesai => pindah ke halaman riwayat
            if ($status === Pesanan::STATUS_SELESAI) {
                $this->redirectRoute('admin.pesanan.riwayat', navigate: true);
                return;
            }

            $this->resetPage();
        } catch (\Throwable $e) {
            $this->dispatch('notyf', type: 'error', message: $e->getMessage());
        }
    }

    public function render()
    {
        $pesanan = Pesanan::query()
            ->with('meja')
            ->whereNotIn('status', [Pesanan::STATUS_SELESAI, Pesanan::STATUS_DIBATALKAN])
            ->orderByDesc('waktu_pesan')
            ->paginate(15);

        return view('livewire.admin.pesanan-masuk', compact('pesanan'))
            ->layout('components.admin-layout');
    }
}