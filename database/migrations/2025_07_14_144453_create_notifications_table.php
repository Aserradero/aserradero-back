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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('calidad');
            $table->double('ancho', 16, 5);
            $table->double('grosor', 16, 5);
            $table->double('largo', 16, 5);
            $table->double('piesTabla', 16, 5);
            $table->boolean('activo')->default(false);
            $table->double('stockIdealPT', 16, 5);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
