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
        Schema::create('konyv_kereseks', function (Blueprint $table) {
            $table->id('keres_id');
            $table->unsignedBigInteger('felhasznalo_id');
            $table->unsignedBigInteger('konyv_id');
            $table->enum('statusz', ['aktiv', 'inaktiv'])->default('aktiv');
            $table->timestamps();

            $table->foreign('felhasznalo_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('konyv_id')->references('konyv_id')->on('konyveks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konyv_kereseks');
    }
};
