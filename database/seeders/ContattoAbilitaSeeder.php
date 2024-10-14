<?php

namespace Database\Seeders;

use App\Models\ContattoAbilita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContattoAbilitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContattoAbilita::create([
            "idContattoAbilita" => 1,
            "nome" => "Leggere",
            "sku" => "leggere"
        ]);
        ContattoAbilita::create([
            "idContattoAbilita" => 2,
            "nome" => "Creare",
            "sku" => "creare"
        ]);
        ContattoAbilita::create([
            "idContattoAbilita" => 3,
            "nome" => "Aggiornare",
            "sku" => "aggiornare"
        ]);
        ContattoAbilita::create([
            "idContattoAbilita" => 4,
            "nome" => "Eliminare",
            "sku" => "eliminare"
        ]);
    }
}
