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
        Schema::create('production_sequence', function (Blueprint $table) {
            $table->id(); // Solo una fila (puedes dejarlo fijo en 1)
            $table->unsignedBigInteger('last_id')->default(0); // para controlar el id manual
            $table->unsignedInteger('last_identificadorP')->default(0); // para el número visible de producción
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_sequence');
    }
};
