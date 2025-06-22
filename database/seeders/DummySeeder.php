<?php

namespace Database\Seeders;

use App\Models\{Barang, Kategori, Lokasi, Penghapusan, RiwayatMutasi};
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // Buat kategori dan lokasi
        Kategori::factory(25)->create();
        Lokasi::factory(25)->create();

        // Buat barang
        Barang::factory(25)->create();

        // Buat riwayat mutasi (20 record)
        RiwayatMutasi::factory(25)->create();

        // Buat penghapusan barang (15 record)
        Penghapusan::factory(25)->create();
    }
}
