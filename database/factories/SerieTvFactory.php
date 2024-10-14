<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\SerieTv;
use Illuminate\Database\Eloquent\Factories\Factory;

class SerieTvFactory extends Factory
{
    public function definition(): array
    {

        return [

            'idCategoria' => Categoria::factory(),
            'nome' => $this->faker->word,
            'descrizione' => $this->faker->paragraph,
            'totaleStagioni' => $this->faker->numberBetween(1, 10),
            'numeroEpisodio' => $this->faker->numberBetween(1, 20),
            'regista' => $this->faker->name,
            'attori' => $this->faker->name,
            'annoInizio' => $this->faker->year,
            'annoFine' => $this->faker->year,
        ];
    }
}
