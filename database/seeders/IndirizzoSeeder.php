<?php

namespace Database\Seeders;

use App\Models\Indirizzo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndirizzoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Indirizzo::create(
            [
                "idIndirizzo" => 1,
                "idTipologiaIndirizzo" => 1,
                "idContatto" => 1,
                "idNazione" => 1,
                "idComune" => 10,
                "cap" => "58100",
                "indirizzo" => "Via Roma",
                "civico" => "10",
                "localita" => "Grosseto",
                "lat" => 146.6754,
                "lng" => 176.8472
            ]
        );
        Indirizzo::create(
            [
                "idIndirizzo" => 2,
                "idTipologiaIndirizzo" => 1,
                "idContatto" => 1,
                "idNazione" => 1,
                "idComune" => 10,
                "cap" => "58100",
                "indirizzo" => "Via Roma",
                "civico" => "10",
                "localita" => "Grosseto",
                "lat" => 146.6754,
                "lng" => 176.8472
            ]
        );
        Indirizzo::create(
            [
                "idIndirizzo" => 3,
                "idTipologiaIndirizzo" => 1,
                "idContatto" => 1,
                "idNazione" => 1,
                "idComune" => 10,
                "cap" => "58100",
                "indirizzo" => "Via Roma",
                "civico" => "10",
                "localita" => "Grosseto",
                "lat" => 146.6754,
                "lng" => 176.8472
            ]
        );
        Indirizzo::create(
            [
                "idIndirizzo" => 4,
                "idTipologiaIndirizzo" => 1,
                "idContatto" => 1,
                "idNazione" => 1,
                "idComune" => 10,
                "cap" => "58100",
                "indirizzo" => "Via Roma",
                "civico" => "10",
                "localita" => "Grosseto",
                "lat" => 146.6754,
                "lng" => 176.8472
            ]
        );
    }
}
