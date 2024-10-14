<?php

namespace Database\Seeders;

use App\Models\Comune;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = storage_path("app/csv_db/comuniItaliani.csv");
        $file = fopen($csv, "r");
        while (($data = fgetcsv($file, 200, ",")) !== false) {
            Comune::create(
                [
                    "idComune" => $data[0],
                    "comune" => $data[1],
                    "regione" => $data[2],
                    "provincia" => $data[3],
                    "siglaAutomobilistica" => $data[4],
                    "numero1" => $data[5],
                    "numero2" => $data[6],
                    "numero3" => $data[7],
                    "numero4" => $data[8],
                    "numero5" => $data[9],
                    "numero6" => $data[10]
                ]
            );
        }
    }
}
