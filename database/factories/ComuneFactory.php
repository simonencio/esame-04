<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comune>
 */
class ComuneFactory extends Factory
{
    public function definition(): array
    {

        return [
            'comune' => $this->faker->unique->city,
            'regione' => $this->faker->state,
            'provincia' => $this->faker->unique->stateAbbr,
            'siglaAutomobilistica' => $this->faker->word,
            'Cod_Catastale' => $this->faker->word,
            'CAP' => $this->faker->randomNumber,
        ];
    }
}
