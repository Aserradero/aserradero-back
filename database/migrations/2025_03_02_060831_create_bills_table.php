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
            $table->float('cantidad', 16, 5);
            $table->char('unidad', 5);
            $table->char('descripcion', 50);
            $table->double('subTotal', 16, 5);
            $table->double('IVA', 16, 5);
            $table->double('precioUnitario', 16, 5);
            $table->double('importeConcepto', 16, 5);
            $table->double('totalVenta', 16, 5);
            $table->char('datosCliente', 50);
            $table->date('fechaCompra');
            $table->char('nombreUsuario', 25);
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
