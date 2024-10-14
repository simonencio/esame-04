<?php

namespace Database\Seeders;

use App\Models\contattiRuoli_contattiAbilita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContattiRuoliContattiAbilitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        contattiRuoli_contattiAbilita::create([
            "id" => 1,
            "idContattoAbilita" => 1,
            "idContattoRuolo" => 1
        ]);
        contattiRuoli_contattiAbilita::create([
            "id" => 2,
            "idContattoAbilita" => 2,
            "idContattoRuolo" => 1
        ]);
        contattiRuoli_contattiAbilita::create([
            "id" => 3,
            "idContattoAbilita" => 3,
            "idContattoRuolo" => 1
        ]);
        contattiRuoli_contattiAbilita::create([
            "id" => 4,
            "idContattoAbilita" => 4,
            "idContattoRuolo" => 1
        ]);
        contattiRuoli_contattiAbilita::create([
            "id" => 5,
            "idContattoAbilita" => 1,
            "idContattoRuolo" => 2
        ]);
        contattiRuoli_contattiAbilita::create([
            "id" => 6,
            "idContattoAbilita" => 3,
            "idContattoRuolo" => 2
        ]);
        contattiRuoli_contattiAbilita::create([
            "id" => 7,
            "idContattoAbilita" => 1,
            "idContattoRuolo" => 3
        ]);
    }
}
