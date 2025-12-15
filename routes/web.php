<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasukMejaController;
use App\Http\Controllers\Admin\MejaAdminController;
use App\Livewire\Pelanggan\DaftarMenu;
use App\Http\Middleware\PastikanMejaTerpilih;
use App\Livewire\Pelanggan\Checkout;
use App\Livewire\Pelanggan\StatusPesanan;
use App\Http\Controllers\StrukController;
use App\Livewire\Admin\AntrianPesanan;
use App\Livewire\Pelanggan\RiwayatPesanan;
use App\Livewire\Admin\DetailPesanan;
use App\Livewire\Admin\StokRendah;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/m/{token}',MasukMejaController::class)
    ->name('masuk.meja');

Route::view('/scan','pelanggan.scan')->name('pelanggan.scan');
Route::middleware([PastikanMejaTerpilih::class])->group(function () {
    Route::get('/menu', DaftarMenu::class)->name('pelanggan.menu');
    Route::get('/checkout', Checkout::class)->name('pelanggan.checkout');
    Route::get('/pesanan/{kode}', StatusPesanan::class)->name('pelanggan.pesanan.status');
    Route::get('/riwayat', RiwayatPesanan::class)->name('pelanggan.riwayat');
    Route::get('/struk/{kode}', [StrukController::class, 'show'])->name('pelanggan.struk');
    Route::get('/struk/{kode}/pdf', [StrukController::class, 'pdf'])->name('pelanggan.struk.pdf');
});  

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/meja', [MejaAdminController::class, 'index'])
        ->name('admin.meja.index');
    Route::get('/pesanan', AntrianPesanan::class)
        ->name('admin.pesanan.index');
    Route::get('/pesanan/{pesanan}', DetailPesanan::class)
        ->name('admin.pesanan.detail');
    Route::get('/stok-rendah', StokRendah::class)
        ->name('admin.stok.rendah');

});
require __DIR__.'/auth.php';
