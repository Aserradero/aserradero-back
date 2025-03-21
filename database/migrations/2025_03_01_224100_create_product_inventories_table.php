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
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->id();
            $table->double('precioUnitario',11,4);
            $table->double('stockIdealPT',11,4);
            $table->timestamps();
           
            //llave forane de usuario

            $table->foreignId('idUsuario')->constrained('users')->onDelete('cascade');
            
      });
    }

  
            

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inventories');
    }
};
