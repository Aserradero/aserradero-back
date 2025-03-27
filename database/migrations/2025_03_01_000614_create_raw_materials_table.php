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
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->double('diametroUno',11,4);
            $table->double('diametroDos',11,4);
            $table->double('largo',11,4);
            $table->double('metroCR',11,4);
            $table->date('fechaRegistro');
            $table->char('calidad',20);
            $table->integer('identificadorP');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
