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
        Schema::create('episodi', function (Blueprint $table) {
            $table->id("idEpisodio");
            $table->unsignedBigInteger('idSerieTv');
            $table->string('titolo', 255);
            $table->string('descrizione', 45);
            $table->tinyInteger("numeroStagione", 3 == false);
            $table->tinyInteger("NumeroEpisodio", 3 == false);
            $table->tinyInteger("durata", 3 == false);
            $table->smallInteger("anno", 5 == false);
            $table->integer("idImmagine", 10 == false);
            $table->integer("idFilmato", 10 == false);
            $table->timestamps();
            $table->foreign("idSerieTv")->references("idSerieTv")->on("serieTv");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodi');
    }
};
