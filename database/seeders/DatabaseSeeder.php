<?php

namespace Database\Seeders;

use App\Models\TipologiaIndirizzo;
use App\Models\TipoRecapito;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                // NazioneSeeder::class,
                // ComuneSeeder::class,
                // TipologiaIndirizzoSeeder::class,
                // StatoSeeder::class,
                // CittadinanzaSeeder::class,
                // ConfigurazioneSeeder::class,
                // ContattoAbilitaSeeder::class,
                // ContattoRuoloSeeder::class,
                // ContattiRuoliContattiAbilitaSeeder::class,
                // LinguaSeeder::class,
                // CategoriaSeeder::class,
                // CreditoSeeder::class,
                // ProfiloSeeder::class,
                // TipoRecapitoSeeder::class,
                // RecapitoSeeder::class,
                // IndirizzoSeeder::class,
                // SerieTvSeeder::class,
                // EpisodioSeeder::class,
                // FilmSeeder::class,
                SerieTvContattiSeeder::class,
                FilmContattiSeeder::class
            ]
        );
    }
}
