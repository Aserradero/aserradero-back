<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Integer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('raw_material_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idMateria');
            $table->integer('stockIdeal');
            $table->foreignId('idUsuario')->nullable()->constrained('users')->onDelete('set null');            
            $table->foreign('idMateria')->references('id')->on('raw_materials')->onDelete('cascade');
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_inventories');
    }
};
