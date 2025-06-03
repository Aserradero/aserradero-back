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
        Schema::create('exit_notes', function (Blueprint $table) {
            $table->id();
            $table->double('metroCT',16,5);
            $table->date('fechaEmision');
            $table->char('nombreUsuario',45);

            $table->timestamps();


            //llaves foraneas
            $table->foreignId('rawMaterialInventory_id')->constrained('raw_material_inventories')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exit_notes');
    }
};
