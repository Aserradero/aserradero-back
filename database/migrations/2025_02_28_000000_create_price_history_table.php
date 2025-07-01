<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('price_history', function (Blueprint $table) {
            $table->id();
            $table->string('calidad');
            $table->double('precio', 16, 5);
            $table->double('grosor', 16, 5);
            $table->double('ancho', 16, 5);
            $table->double('largo', 16, 5);
            $table->date('fechaRegistro');
            $table->date('fechaActualizada');
            $table->integer('idUsuario');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_history');
    }
};
