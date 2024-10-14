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
        Schema::create('contatti_contattiRuoli', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idContatto', 20 == false)->unsigned();
            $table->unsignedBigInteger('idContattoRuolo', 20 == false)->unsigned();
            $table->timestamps();
            $table->foreign("idContatto")->references("idContatto")->on("contatti");
            $table->foreign("idContattoRuolo")->references("idContattoRuolo")->on("contattiRuoli");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatti_contattiRuoli');
    }
};
