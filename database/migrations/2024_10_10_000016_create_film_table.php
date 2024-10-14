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
        Schema::create('film', function (Blueprint $table) {
            $table->id("idFilm");
            $table->unsignedBigInteger('idCategoria');
            $table->string('titolo', 255);
            $table->string('descrizione', 45);
            $table->tinyInteger("durata", 3 == false);
            $table->string('regista', 45);
            $table->string('attori', 45);
            $table->smallInteger("anno", 5 == false);
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
        Schema::dropIfExists('film');
    }
};
