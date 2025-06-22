<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->words(2, true),
            'kode_barang' => strtoupper($this->faker->bothify('BRG-###??')),
            'kategori_id' => Kategori::inRandomOrder()->first()?->id ?? Kategori::factory(),
            'lokasi_id' => Lokasi::inRandomOrder()->first()?->id ?? Lokasi::factory(),
            'jumlah' => $this->faker->numberBetween(1, 50),
        ];
    }
}
