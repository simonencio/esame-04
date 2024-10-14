<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cittadinanza>
 */
class CittadinanzaFactory extends Factory
{
    public function definition(): array
    {

        return [
            'nome' => $this->faker->word,
        ];
    }
}
