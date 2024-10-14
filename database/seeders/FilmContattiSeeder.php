<?php

namespace Database\Seeders;

use App\Models\Film_Contatti;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmContattiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Film_Contatti::create(

            [
                "idFilmContatto" => 1,
                "idFilm" => 1,
                "idContatto" => 1
            ]
        );
        Film_Contatti::create(

            [
                "idFilmContatto" => 2,
                "idFilm" => 2,
                "idContatto" => 1
            ]
        );
        Film_Contatti::create(

            [
                "idFilmContatto" => 3,
                "idFilm" => 3,
                "idContatto" => 1
            ]
        );
        Film_Contatti::create(

            [
                "idFilmContatto" => 4,
                "idFilm" => 4,
                "idContatto" => 1
            ]
        );
    }
}
