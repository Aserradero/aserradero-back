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
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->double('cantidad',16,5);
             $table->double('precioh',16,5);
            $table->foreignId('producto_id')->constrained('products')->onDelete('restrict');
            $table->foreignId('sale_id')->constrained('sales')->onDelete('restrict');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sales');
    }
};
