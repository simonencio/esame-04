<?php

namespace Database\Seeders;

use App\Models\Episodio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EpisodioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Episodio::create(
            [
                "idEpisodio" => 1,
                "idSerieTv" => 1,
                "titolo" => "Indiana Jones",
                "descrizione" => "Indiana Jones",
                "numeroStagione" => 1,
                "NumeroEpisodio" => 1,
                "durata" => 20,
                "anno" => 1998
            ]
        );
        Episodio::create(
            [
                "idEpisodio" => 2,
                "idSerieTv" => 2,
                "titolo" => "Indiana Jones",
                "descrizione" => "Indiana Jones",
                "numeroStagione" => 1,
                "NumeroEpisodio" => 1,
                "durata" => 20,
                "anno" => 1998
            ]
        );
        Episodio::create(

            [
                "idEpisodio" => 3,
                "idSerieTv" => 3,
                "titolo" => "Indiana Jones",
                "descrizione" => "Indiana Jones",
                "numeroStagione" => 1,
                "NumeroEpisodio" => 1,
                "durata" => 20,
                "anno" => 1998
            ]
        );
        Episodio::create(

            [
                "idEpisodio" => 4,
                "idSerieTv" => 4,
                "titolo" => "Indiana Jones",
                "descrizione" => "Indiana Jones",
                "numeroStagione" => 1,
                "NumeroEpisodio" => 1,
                "durata" => 20,
                "anno" => 1998
            ]
        );
    }
}

// Episodio::create(
//     [
//         "idFilm" => 1,
//         "idCategoria" => 3,
//         "titolo" => "Batman",
//         "descrizione" => "Batman",
//         "durata" => 120,
//         "regista" => "Christopher Nolan",
//         "attori" => "Christian Bale",
//         "anno" => 1998
//     ],

// );
