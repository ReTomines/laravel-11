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
        Schema::create('localizations', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });
    
        // Inserção direta dos dados fixos
        DB::table('localizations')->insert([
            ['nome' => '1º PAVIMENTO'],
            ['nome' => '2º PAVIMENTO'],
            ['nome' => '3º PAVIMENTO'],
            ['nome' => '4º PAVIMENTO'],
            ['nome' => '5º PAVIMENTO'],
            ['nome' => '6º PAVIMENTO'],
            ['nome' => '7º PAVIMENTO'],
            ['nome' => '8º PAVIMENTO'],
            ['nome' => '9º PAVIMENTO'],
            ['nome' => '10º PAVIMENTO'],
            ['nome' => 'PALÁCIO'],
            ['nome' => 'SUBSOLO'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};