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
            $table->unsignedBigInteger('idProducto');
            $table->double('precioUnitario',16,5);
            $table->double('stockIdealPT',16,5);
            $table->double('stockActual',16,5);
            $table->foreignId('idUsuario')->nullable()->constrained('users')->onDelete('set null');
            $table->foreign('idProducto')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();          
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
