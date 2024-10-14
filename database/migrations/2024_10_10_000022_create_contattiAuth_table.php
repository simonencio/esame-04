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
        Schema::create('contattiAuth', function (Blueprint $table) {
            $table->id("idContattoAuth");
            $table->unsignedBigInteger('idContatto', 20 == false)->unsigned();
            $table->string('user', 255)->unique('user');
            $table->string("sfida", 255);
            $table->string("secretJWT", 500);
            $table->unsignedInteger("inizioSfida", 10 == false)->unsigned();
            $table->unsignedTinyInteger('obbligoCampo', 3 == false)->unsigned();
            $table->foreign("idContatto")->references("idContatto")->on("contatti");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contattiAuth');
    }
};
