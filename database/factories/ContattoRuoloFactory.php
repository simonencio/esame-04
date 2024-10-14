<?php

namespace Database\Factories;

use App\Models\ContattoRuolo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContattoRuoloFactory extends Factory
{
    protected $model = ContattoRuolo::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
        ];
    }
}
