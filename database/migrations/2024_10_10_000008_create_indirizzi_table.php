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
        Schema::create('indirizzi', function (Blueprint $table) {
            $table->id("idIndirizzo");
            $table->unsignedBigInteger('idTipologiaIndirizzo');
            $table->unsignedBigInteger('idContatto');
            $table->unsignedBigInteger('idNazione');
            $table->unsignedBigInteger('idComune');
            $table->string('cap', 15)->nullable();
            $table->string('indirizzo', 45);
            $table->string('civico', 15)->nullable();
            $table->string('localita', 45)->nullable();
            $table->float('lat');
            $table->float('lng');
            $table->string('altro_1', 45);
            $table->string('altro_2', 45);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("idContatto")->references("idContatto")->on("contatti");
            $table->foreign('idTipologiaIndirizzo')->references('idTipologiaIndirizzo')->on('tipologiaIndirizzi');
            $table->foreign('idNazione')->references('idNazione')->on('nazioni');
            $table->foreign('idComune')->references('idComune')->on('comuni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indirizzi');
    }
};
