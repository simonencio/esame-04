<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class CategoriaFactory extends Factory
{
    public function definition(): array
    {

        return [
            'nome' => $this->faker->word,
        ];
    }
}
