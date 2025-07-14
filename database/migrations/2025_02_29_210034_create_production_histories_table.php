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
        Schema::create('production_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->double('coeficiente', 16, 5)->nullable();
            $table->double('m3TRM', 16, 5);
            $table->double('piesTablaTP', 16, 5)->nullable();
            $table->timestamp('fechaFinalizacion')->nullable();
            $table->integer('identificadorP')->unique();
            $table->string('estatus')->default('En espera de procesamiento');
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
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
