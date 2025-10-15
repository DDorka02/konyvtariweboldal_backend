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
        Schema::create('statisztikas', function (Blueprint $table) {
            $table->id('stat_id');
            $table->date('datum');
            $table->integer('regisztralt_felhasznalok')->default(0);
            $table->integer('hozzaadott_konyvek')->default(0);
            $table->integer('aktiv_cserék')->default(0);
            $table->integer('lezart_cserék')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statisztikas');
    }
};
