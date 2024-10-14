<?php

namespace Database\Seeders;

use App\Models\Lingua;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinguaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lingua::create([
            "idLingua" => 1,
            "nome" => "Italiano",
            "abbreviazione" => "Ita"
        ]);
        Lingua::create([
            "idLingua" => 2,
            "nome" => "Inglese",
            "abbreviazione" => "Ing"
        ]);
        Lingua::create([
            "idLingua" => 3,
            "nome" => "Tedesco",
            "abbreviazione" => "Deu"
        ]);
        Lingua::create([
            "idLingua" => 4,
            "nome" => "Francese",
            "abbreviazione" => "Fra"
        ]);
    }
}
