<?php

namespace Database\Seeders;

use App\Models\SerieTv;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SerieTvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SerieTv::create(
            [
                "idSerieTv" => 1,
                "idCategoria" => 3,
                "nome" => "Indiana Jones",
                "descrizione" => "Indiana Jones",
                "totaleStagioni" => 2,
                "NumeroEpisodio" => 10,
                "regista" => "Indiana Jones",
                "attori" => "Indiana Jones",
                "annoInizio" => 1998,
                "annoFine" => 2000
            ]
        );

        SerieTv::create(
            [
                "idSerieTv" => 2,
                "idCategoria" => 3,
                "nome" => "Indiana Jones",
                "descrizione" => "Indiana Jones",
                "totaleStagioni" => 2,
                "NumeroEpisodio" => 10,
                "regista" => "Indiana Jones",
                "attori" => "Indiana Jones",
                "annoInizio" => 1998,
                "annoFine" => 2000
            ]
        );
        SerieTv::create(
            [
                "idSerieTv" => 3,
                "idCategoria" => 3,
                "nome" => "Indiana Jones",
                "descrizione" => "Indiana Jones",
                "totaleStagioni" => 2,
                "NumeroEpisodio" => 10,
                "regista" => "Indiana Jones",
                "attori" => "Indiana Jones",
                "annoInizio" => 1998,
                "annoFine" => 2000
            ]
        );
        SerieTv::create(
            [
                "idSerieTv" => 4,
                "idCategoria" => 3,
                "nome" => "Indiana Jones",
                "descrizione" => "Indiana Jones",
                "totaleStagioni" => 2,
                "NumeroEpisodio" => 10,
                "regista" => "Indiana Jones",
                "attori" => "Indiana Jones",
                "annoInizio" => 1998,
                "annoFine" => 2000
            ]
        );
    }
}
