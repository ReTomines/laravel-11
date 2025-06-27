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
        Schema::create('vereadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome_politico');
            $table->string('foto_ver');
            $table->enum('titulo', ['vereador', 'vereadora']);
            $table->string('abrev_titulo')->nullable();
            $table->unsignedBigInteger('pavimento');
            $table->string('sala');
            $table->string('logo_partido')->nullable(); // caso o logo seja opcional

            // Novo campo partido_id com chave estrangeira
            $table->unsignedBigInteger('partido_id')->nullable();
            $table->foreign('partido_id')
                  ->references('id')
                  ->on('partidos')
                  ->cascadeOnDelete(); 

            // chave estrangeira para localizations
            $table->foreign('pavimento')
                  ->references('id')
                  ->on('localizations')
                  ->cascadeOnDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vereadores');
    }
};
