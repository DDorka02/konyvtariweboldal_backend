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
        Schema::create('felhasznalo_konyveks', function (Blueprint $table) {
            $table->id('felhasznalo_konyv_id');
            $table->unsignedBigInteger('felhasznalo_id');
            $table->unsignedBigInteger('konyv_id');
            $table->enum('statusz', ['elerheto', 'foglalt', 'kicserelve'])->default('elerheto');
            $table->text('megjegyzes')->nullable(); // pl. "kissé kopott a sarka"
            $table->timestamps();

            $table->foreign('felhasznalo_id')->references('azonosito')->on('users')->onDelete('cascade');
            $table->foreign('konyv_id')->references('konyv_id')->on('konyveks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('felhasznalo_konyveks');
    }
};
