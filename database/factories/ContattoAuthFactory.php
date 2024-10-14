<?php

namespace Database\Factories;

use App\Models\ContattoAuth;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContattoAuthFactory extends Factory
{
    protected $model = ContattoAuth::class;

    public function definition()
    {
        return [
            'user' => $this->faker->unique()->userName,
            'sfida' => $this->faker->sha256,
            'secretJWT' => $this->faker->sha256,
            'inizioSfida' => time(),
            'obbligoCampo' => 1,
            // ... other fields
        ];
    }
}
