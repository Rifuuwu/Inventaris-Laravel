<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenghapusanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'barang_id' => Barang::inRandomOrder()->first()?->id ?? Barang::factory(),
            'alasan' => $this->faker->sentence(),
            'tanggal' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
