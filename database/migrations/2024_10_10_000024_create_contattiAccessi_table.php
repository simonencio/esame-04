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
        Schema::create('contattiAccessi', function (Blueprint $table) {
            $table->id("id");
            $table->unsignedBigInteger('idContatto', 20 == false);
            $table->unsignedTinyInteger('autenticato', 3 == false)->unsigned()->index('autenticato');
            $table->string('ip', 15)->nullable();
            $table->timestamps();
            $table->foreign("idContatto")->references("idContatto")->on("contatti");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contattiAccessi');
    }
};
