<?php

namespace Database\Factories;

use App\Models\Cittadinanza;
use App\Models\Comune;
use App\Models\Contatto;
use App\Models\Nazione;
use App\Models\Stato;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContattoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'idStato' => Stato::factory(),
            'idCittadinanza' => Cittadinanza::factory(),
            'idNazioneNascita' => Nazione::factory(),
            'CittaNascita' => Comune::factory('comune'),
            'ProvNascita' => Comune::factory('provincia'),
            'nome' => $this->faker->firstName,
            'cognome' => $this->faker->lastName,
            'sesso' => $this->faker->numberBetween(0, 1),
            'codiceFiscale' => $this->faker->randomNumber(9),
            'partitaIva' => $this->faker->randomNumber(9),
            'dataNascita' => $this->faker->date,
        ];
    }
}
