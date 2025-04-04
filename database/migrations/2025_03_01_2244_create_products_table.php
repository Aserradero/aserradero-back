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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->double('precio', 10, 4);
            $table->char('calidad', 20);
            $table->integer('cantidad');
            $table->double('ancho', 11, 4);
            $table->double('grosor', 11, 4);
            $table->double('largo', 11, 4);
            $table->double('piesTabla', 11, 4);
            $table->date('fechaRegistro');
            $table->integer('identificadorP');
            $table->timestamps();


            //llave foranea nombre de la llave forenea-> referencia a la tabla y en automatico toma el id
            

    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
