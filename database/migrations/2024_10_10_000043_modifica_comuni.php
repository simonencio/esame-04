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
        Schema::table("comuni", function (Blueprint $table) {
            $table->dropColumn("numero2");
            $table->dropColumn("numero3");
            $table->dropColumn("numero5");
            $table->dropColumn("numero6");
            $table->renameColumn("numero1", 'Cod_Catastale');
            $table->renameColumn("numero4", 'CAP');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
