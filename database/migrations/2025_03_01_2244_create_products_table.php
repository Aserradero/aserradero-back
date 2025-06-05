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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->double('precio', 16, 5);
            $table->string('calidad');
            $table->integer('cantidad');
            $table->double('ancho', 16, 5);
            $table->double('grosor', 16, 5);
            $table->double('largo', 16, 5);
            $table->double('piesTabla', 16, 5);
            $table->date('fechaRegistro');
            $table->foreignId(column: 'identificadorP')->nullable()->constrained('production_histories');

            //$table->integer('identificadorP');
            //crear una llave foranea
            $table->foreignId('idCatalogProduct')->constrained('catalog_products')->onDelete('restrict');
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
