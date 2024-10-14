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
        Schema::create('recapiti', function (Blueprint $table) {
            $table->id("idRecapito");
            $table->unsignedBigInteger('idContatto');
            $table->unsignedBigInteger('idTipoRecapito');
            $table->string("recapito", 255);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("idContatto")->references("idContatto")->on("contatti");
            $table->foreign('idTipoRecapito')->references('idTipoRecapito')->on('tipiRecapiti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recapiti');
    }
};
