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
        Schema::create('contatti', function (Blueprint $table) {
            $table->id("idContatto");
            $table->unsignedBigInteger('idStato');
            $table->unsignedBigInteger('idCittadinanza');
            $table->unsignedBigInteger('idNazioneNascita');
            $table->char('cittàNascita', 45);
            $table->char('provNascita', 45);
            $table->string('nome', 45)->nullable();
            $table->string('cognome', 45);
            $table->unsignedTinyInteger('sesso')->unsigned()->nullable();
            $table->string('codiceFiscale', 45);
            $table->string('partitaIva', 45);
            $table->date("dataNascita");
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("idStato")->references("idStato")->on("stati");
            // $table->foreign("idCittadinanza")->references("idCittadinanza")->on("cittadinanze");
            // $table->foreign("idNazioneNascita")->references("idNazione")->on("nazioni");
            // $table->foreign("CittàNascita")->references("comune")->on("comuni");
            // $table->foreign("ProvNascita")->references("provincia")->on("comuni");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatti');
    }
};
