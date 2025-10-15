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
        Schema::create('konyveks', function (Blueprint $table) {
            $table->id('konyv_id');
            $table->string('cim');
            $table->string('szerzo');
            $table->string('kiado')->nullable();
            $table->integer('kiadas_ev')->nullable();
            $table->string('kategoria'); // pl. "regény", "sci-fi", "tankönyv"
            $table->text('leiras')->nullable();
            $table->string('kep')->nullable();
            $table->string('allapot'); // "új", "jó", "közepes", "elhasznált"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konyveks');
    }
};
