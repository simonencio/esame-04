<?php

namespace Database\Seeders;

use App\Models\Recapito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecapitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recapito::create(
            [
                "idRecapito" => 1,
                "idContatto" => 1,
                "idTipoRecapito" => 1,
                "recapito" => 3337217293
            ]
        );
        Recapito::create(
            [
                "idRecapito" => 2,
                "idContatto" => 1,
                "idTipoRecapito" => 1,
                "recapito" => 3337217293
            ]
        );
        Recapito::create(
            [
                "idRecapito" => 3,
                "idContatto" => 1,
                "idTipoRecapito" => 1,
                "recapito" => 3337217293
            ]
        );
        Recapito::create(
            [
                "idRecapito" => 4,
                "idContatto" => 1,
                "idTipoRecapito" => 1,
                "recapito" => 3337217293
            ]

        );
    }
}
