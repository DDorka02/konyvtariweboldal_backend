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
        Schema::create('kicsereleseks', function (Blueprint $table) {
            $table->id('csere_id');
            $table->unsignedBigInteger('felado_id'); // ki adja a könyvet
            $table->unsignedBigInteger('fogado_id'); // ki kapja a könyvet
            $table->unsignedBigInteger('felado_konyv_id'); // melyik könyv adódik
            $table->unsignedBigInteger('fogado_konyv_id')->nullable(); // melyik könyv kapódik (ha kölcsönös csere)
            $table->enum('statusz', ['fuggo', 'elfogadva', 'elutasitva', 'lezarva'])->default('fuggo');
            $table->timestamps();

            $table->foreign('felado_id')->references('azonosito')->on('users')->onDelete('cascade');
            $table->foreign('fogado_id')->references('azonosito')->on('users')->onDelete('cascade');
            $table->foreign('felado_konyv_id')->references('felhasznalo_konyv_id')->on('felhasznalo_konyveks');
            $table->foreign('fogado_konyv_id')->references('felhasznalo_konyv_id')->on('felhasznalo_konyveks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kicsereleseks');
    }
};
