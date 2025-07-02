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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->double('piesTablaTotal', 16, 3);
            $table->string('nombreCliente', 100);
            $table->string('rfc', 20);
            $table->string('telefono', 15);
            $table->string('direccion', 100);
            $table->string('importeLetra', 100);
            $table->string('tipoVenta', 50);
            $table->double('subtotal', 16,3);
            $table->double('iva', 16,3);
            $table->double('total', 16,3);
            

            $table->timestamps();

            //llaves foraneas
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
