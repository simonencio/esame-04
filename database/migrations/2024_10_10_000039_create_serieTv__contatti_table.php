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
        Schema::create('serieTv__contatti', function (Blueprint $table) {
            $table->id("idSerieContatto");
            $table->unsignedBigInteger('idSerieTv');
            $table->unsignedBigInteger('idContatto');
            $table->timestamps();
            $table->foreign("idSerieTv")->references("idSerieTv")->on("serieTv");
            $table->foreign("idContatto")->references("idContatto")->on("contatti");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serieTv__contatti');
    }
};
