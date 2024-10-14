<?php

namespace Database\Seeders;

use App\Models\serieTv_Contatti;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SerieTvContattiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        serieTv_Contatti::create(

            [
                "idSerieContatto" => 1,
                "idSerieTv" => 1,
                "idContatto" => 1
            ]
        );
        serieTv_Contatti::create(

            [
                "idSerieContatto" => 2,
                "idSerieTv" => 2,
                "idContatto" => 1
            ]
        );
        serieTv_Contatti::create(

            [
                "idSerieContatto" => 3,
                "idSerieTv" => 3,
                "idContatto" => 1
            ]
        );
        serieTv_Contatti::create(

            [
                "idSerieContatto" => 4,
                "idSerieTv" => 4,
                "idContatto" => 1
            ]
        );
    }
}
