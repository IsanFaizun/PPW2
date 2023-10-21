<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => $this->faker->text($maxNbChars = 50),
            'penulis' => $this->faker->name(),
            'tgl_terbit' => $this->faker->date($format='Y-m-d', $max='now'),
            'harga' => $this->faker->numberBetween($min = 40000, $max = 150000)
        ];
    }
}
