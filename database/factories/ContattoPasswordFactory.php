<?php

namespace Database\Factories;

use App\Models\Contatto;
use App\Models\ContattoPassword;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContattoPasswordFactory extends Factory
{
    protected $model = ContattoPassword::class;

    public function definition()
    {
        return [
            'idContatto' => Contatto::factory(),
            'psw' => $this->faker->password,
            'sale' => $this->faker->randomDigit,
        ];
    }
}
