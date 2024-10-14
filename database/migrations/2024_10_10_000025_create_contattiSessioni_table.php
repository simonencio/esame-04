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
        Schema::create('contattiSessioni', function (Blueprint $table) {
            $table->id("idContattoSessione");
            $table->unsignedBigInteger('idContatto', 20 == false)->unsigned();
            $table->string("token", 500);
            $table->unsignedBigInteger("inizioSessione", 20 == false)->unsigned();
            $table->timestamps();
            $table->foreign("idContatto")->references("idContatto")->on("contatti");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contattiSessioni');
    }
};
