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
            $table->enum('titulo', ['vereador', 'vereadora']);
            $table->string('nome_politico');
            $table->string('logo_partido')->nullable(); // caso o logo seja opcional
            $table->unsignedBigInteger('pavimento');
            $table->string('sala')->nullable();

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