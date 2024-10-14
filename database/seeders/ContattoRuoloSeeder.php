<?php

namespace Database\Seeders;

use App\Models\ContattoRuolo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContattoRuoloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContattoRuolo::create([
            "idContattoRuolo" => 1,
            "nome" => "Amministratore"
        ]);
        ContattoRuolo::create([
            "idContattoRuolo" => 2,
            "nome" => "Utente"
        ]);
        ContattoRuolo::create([
            "idContattoRuolo" => 3,
            "nome" => "Ospite"
        ]);
    }
}
