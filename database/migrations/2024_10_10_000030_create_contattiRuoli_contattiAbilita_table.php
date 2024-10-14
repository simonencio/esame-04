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
        Schema::create('contattiRuoli_contattiAbilita', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idContattoAbilita', 20 == false)->unsigned();
            $table->unsignedBigInteger('idContattoRuolo', 20 == false)->unsigned();
            $table->timestamps();
            $table->foreign("idContattoAbilita")->references("idContattoAbilita")->on("contattiAbilita");
            $table->foreign("idContattoRuolo")->references("idContattoRuolo")->on("contattiRuoli");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contattiRuoli_contattiAbilita');
    }
};
