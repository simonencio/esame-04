<?php

namespace Database\Factories;

use App\Models\Contatto;
use App\Models\ContattoSessione;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContattoSessioneFactory extends Factory
{
    protected $model = ContattoSessione::class;

    public function definition()
    {
        return [
            'idContatto' => Contatto::factory(),
            'token' => $this->faker->uuid,
            'inizioSessione' => $this->faker->time,
        ];
    }
}
