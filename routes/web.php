<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


use App\Livewire\Barang\Index as BarangIndex;
use App\Livewire\Barang\Form as BarangForm;
use App\Livewire\Lokasi\Index as LokasiIndex;
use App\Livewire\Lokasi\Form as LokasiForm;
use App\Livewire\Fitur\BarangAktif;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    // Barang routes
    Route::get('/barang', App\Livewire\Barang\Index::class)->name('barang.index');
    Route::get('/barang/create', BarangForm::class)->name('barang.create');
    Route::get('/barang/{id}/edit', BarangForm::class)->name('barang.edit');
    Route::get('/barang/{id}/mutasi', BarangForm::class)->name('barang.mutasi');
    Route::get('/barang-aktif', BarangAktif::class)->name('laporan.barang');

    // Lokasi routes
    Route::get('/lokasi', App\Livewire\Lokasi\Index::class)->name('lokasi.index');
    Route::get('/lokasi/create', App\Livewire\Lokasi\Form::class)->name('lokasi.create');
    Route::get('/lokasi/{lokasi}/edit', App\Livewire\Lokasi\Form::class)->name('lokasi.edit');


    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
