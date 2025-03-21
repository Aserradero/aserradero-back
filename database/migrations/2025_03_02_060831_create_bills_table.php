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
            $table->float('cantidad', 11, 4);
            $table->char('unidad', 5);
            $table->char('descripcion', 50);
            $table->double('subTotal', 11, 4);
            $table->double('IVA', 11, 4);
            $table->double('precioUnitario', 11, 4);
            $table->double('importeConcepto', 11, 4);
            $table->double('totalVenta', 11, 4);
            $table->char('datosCliente', 50);
            $table->date('fechaCompra');
            $table->char('nombreUsuario', 25);
            $table->timestamps();

            //llaves foraneas
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
