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
        Schema::create('production_histories', function (Blueprint $table) {
            $table->id();
            $table->double('coeficiente',11,2);
            $table->double('m3TRM',11,2);
            $table->double('piesTablaTP',11,2);
            $table->date('fechaFinalizacion');
            $table->integer('identificadorP');
            $table->timestamps();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            //$table->foreignId('product_id')->constrained('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_histories');
    }
};
