<?php

namespace Database\Seeders;

use App\Models\TipoRecapito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoRecapitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoRecapito::create(
            [
                "idTiporecapito" => 1,
                "nome" => "ufficio"
            ]
        );
        TipoRecapito::create(
            [
                "idTiporecapito" => 2,
                "nome" => "ufficio"
            ]
        );
        TipoRecapito::create(
            [
                "idTiporecapito" => 3,
                "nome" => "ufficio"
            ]
        );
        TipoRecapito::create(
            [
                "idTiporecapito" => 4,
                "nome" => "ufficio"
            ]

        );
    }
}
