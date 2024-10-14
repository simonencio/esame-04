<?php

namespace Database\Seeders;

use App\Models\Cittadinanza;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CittadinanzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = storage_path("app/csv_db/Cittadinanze.csv");
        $file = fopen($csv, "r");
        while (($data = fgetcsv($file, 200)) !== false) {
            Cittadinanza::create(
                [
                    "nome" => $data[0]
                ]
            );
        }
    }
}
