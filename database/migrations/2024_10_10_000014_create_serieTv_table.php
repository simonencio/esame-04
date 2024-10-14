<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('serieTv', function (Blueprint $table) {
            $table->id("idSerieTv");
            $table->unsignedBigInteger('idCategoria');
            $table->string('nome', 255);
            $table->string('descrizione', 45);
            $table->tinyInteger("totaleStagioni", 3 == false);
            $table->tinyInteger("NumeroEpisodio", 3 == false);
            $table->string('regista', 45);
            $table->string('attori', 45);
            $table->smallInteger("annoInizio", 5 == false);
            $table->smallInteger("annoFine", 5 == false);
            $table->integer("idImmagine", 10 == false);
            $table->integer("idFilmato", 10 == false);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("idCategoria")->references("idCategoria")->on("categorie");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serieTv');
    }
};
