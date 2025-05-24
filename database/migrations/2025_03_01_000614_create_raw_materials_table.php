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
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->double('diametroUno', 16, 5);
            $table->double('diametroDos', 16, 5);
            $table->double('largo', 16, 5);
            $table->double('metroCR', 16, 5);
            $table->date('fechaRegistro');
            $table->char('calidad', 20);
            //$table->integer('identificadorP');
            $table->foreignId(column: 'identificadorP')->nullable()->constrained('production_histories');


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
