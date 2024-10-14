<?php

namespace Database\Seeders;

use App\Models\TipologiaIndirizzo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipologiaIndirizzoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipologiaIndirizzo::create(["idTipologiaIndirizzo" => 1, "nome" => "Residenza Primaria"]);
        TipologiaIndirizzo::create(["idTipologiaIndirizzo" => 2, "nome" => "Residenza Secondaria"]);
        TipologiaIndirizzo::create(["idTipologiaIndirizzo" => 3, "nome" => "Domicilio"]);
        TipologiaIndirizzo::create(["idTipologiaIndirizzo" => 4, "nome" => "Ufficio"]);
    }
}
