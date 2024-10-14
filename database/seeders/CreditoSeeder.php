<?php

namespace Database\Seeders;

use App\Models\Credito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Credito::create(
            [
                "idCredito" => 1,
                "idContatto" => 1,
                "credito" => 30
            ]
        );
        Credito::create(
            [
                "idCredito" => 2,
                "idContatto" => 1,
                "credito" => 30
            ]
        );
        Credito::create(
            [
                "idCredito" => 3,
                "idContatto" => 1,
                "credito" => 30
            ]
        );
        Credito::create(
            [
                "idCredito" => 4,
                "idContatto" => 1,
                "credito" => 30
            ]

        );
    }
}
