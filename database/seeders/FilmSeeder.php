<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Film::create(
            [
                "idFilm" => 1,
                "idCategoria" => 3,
                "titolo" => "Batman",
                "descrizione" => "Batman",
                "durata" => 120,
                "regista" => "Christopher Nolan",
                "attori" => "Christian Bale",
                "anno" => 1998
            ]
        );
        Film::create(
            [
                "idFilm" => 2,
                "idCategoria" => 3,
                "titolo" => "Batman",
                "descrizione" => "Batman",
                "durata" => 120,
                "regista" => "Christopher Nolan",
                "attori" => "Christian Bale",
                "anno" => 1998
            ]
        );
        Film::create(
            [
                "idFilm" => 3,
                "idCategoria" => 3,
                "titolo" => "Batman",
                "descrizione" => "Batman",
                "durata" => 120,
                "regista" => "Christopher Nolan",
                "attori" => "Christian Bale",
                "anno" => 1998
            ]
        );
        Film::create(
            [
                "idFilm" => 4,
                "idCategoria" => 3,
                "titolo" => "Batman",
                "descrizione" => "Batman",
                "durata" => 120,
                "regista" => "Christopher Nolan",
                "attori" => "Christian Bale",
                "anno" => 1998
            ]
        );
    }
}
