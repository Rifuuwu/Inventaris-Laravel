<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LokasiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_lokasi' => $this->faker->city(),
            'gedung' => 'Gedung ' . $this->faker->randomLetter(),
        ];
    }
}
