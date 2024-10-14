<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nazione>
 */
class NazioneFactory extends Factory
{
    public function definition(): array
    {

        return [
            'nome' => $this->faker->word,
            'continente' => $this->faker->word,
            'iso' => $this->faker->word,
            'iso3' => $this->faker->word,
            'prefissoTelefonico' => $this->faker->randomNumber(1, 50),
        ];
    }
}
