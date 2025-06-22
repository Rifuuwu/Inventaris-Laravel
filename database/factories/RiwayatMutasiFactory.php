<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiwayatMutasiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'barang_id' => Barang::inRandomOrder()->first()?->id ?? Barang::factory(),
            'asal' => $this->faker->city(),
            'tujuan' => $this->faker->city(),
            'tanggal' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
