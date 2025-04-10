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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->char('apellidos',50)->nullable();
            $table->char('telefono',10)->nullable()->unique(); //esto cambie que sea unico
            $table->char('genero',1)->nullable();
            $table->char('nombreUsuario',25)->nullable()->unique(); //esto cambie a que sea unico
            $table->string('contrasena')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();


        });
    }

    /**t
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
