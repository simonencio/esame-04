<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            "idCategoria" => 1,
            "nome" => "Adolescenziale"
        ]);
        Categoria::create([
            "idCategoria" => 2,
            "nome" => "Anime"
        ]);
        Categoria::create([
            "idCategoria" => 3,
            "nome" => "Azione"
        ]);
        Categoria::create([
            "idCategoria" => 4,
            "nome" => "Bambini"
        ]);
        Categoria::create([
            "idCategoria" => 5,
            "nome" => "Britannici"
        ]);
        Categoria::create([
            "idCategoria" => 6,
            "nome" => "Commedie"
        ]);
        Categoria::create([
            "idCategoria" => 7,
            "nome" => "Crime"
        ]);
        Categoria::create([
            "idCategoria" => 8,
            "nome" => "Docuserie"
        ]);
        Categoria::create([
            "idCategoria" => 9,
            "nome" => "Drammi"
        ]);
        Categoria::create([
            "idCategoria" => 10,
            "nome" => "Europei"
        ]);
        Categoria::create([
            "idCategoria" => 11,
            "nome" => "Fantascienza"
        ]);
        Categoria::create([
            "idCategoria" => 12,
            "nome" => "Gialli"
        ]);
        Categoria::create([
            "idCategoria" => 13,
            "nome" => "Halloween"
        ]);
        Categoria::create([
            "idCategoria" => 14,
            "nome" => "Horror"
        ]);
        Categoria::create([
            "idCategoria" => 15,
            "nome" => "Internazionali"
        ]);
        Categoria::create([
            "idCategoria" => 16,
            "nome" => "Italiani"
        ]);
        Categoria::create([
            "idCategoria" => 17,
            "nome" => "Reality"
        ]);
        Categoria::create([
            "idCategoria" => 18,
            "nome" => "Romantici"
        ]);
        Categoria::create([
            "idCategoria" => 19,
            "nome" => "Scienza"
        ]);
        Categoria::create([
            "idCategoria" => 20,
            "nome" => "Sport"
        ]);
        Categoria::create([
            "idCategoria" => 21,
            "nome" => "Thriller"
        ]);
        Categoria::create([
            "idCategoria" => 22,
            "nome" => "USA"
        ]);
    }
}
