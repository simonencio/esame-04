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
        Schema::create('film_Contatti', function (Blueprint $table) {
            $table->id("idFilmContatto");
            $table->unsignedBigInteger('idFilm');
            $table->unsignedBigInteger('idContatto');
            $table->timestamps();
            $table->foreign("idFilm")->references("idFilm")->on("film");
            $table->foreign("idContatto")->references("idContatto")->on("contatti");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_Contatti');
    }
};
