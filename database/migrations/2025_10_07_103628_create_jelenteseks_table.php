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
        Schema::create('jelenteseks', function (Blueprint $table) {
            $table->id('jelentes_id');
            $table->unsignedBigInteger('bejelento_id'); // ki jelent
            $table->unsignedBigInteger('cel_felhasznalo_id')->nullable(); // kit jelent
            $table->unsignedBigInteger('cel_konyv_id')->nullable(); // melyik könyvet jelent
            $table->enum('tipus', ['sertes', 'hamis_adat', 'nem_elerheto', 'egyeb']);
            $table->text('leiras');
            $table->enum('statusz', ['fuggo', 'feldolgozva', 'elutasitva'])->default('fuggo');
            $table->unsignedBigInteger('admin_id')->nullable(); // melyik admin dolgozta fel
            $table->text('admin_megjegyzes')->nullable();
            $table->timestamps();

            $table->foreign('bejelento_id')->references('azonosito')->on('users')->onDelete('cascade');
            $table->foreign('cel_felhasznalo_id')->references('azonosito')->on('users')->onDelete('cascade');
            $table->foreign('cel_konyv_id')->references('konyv_id')->on('konyveks');
            $table->foreign('admin_id')->references('azonosito')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jelenteseks');
    }
};
