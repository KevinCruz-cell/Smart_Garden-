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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();

            // Usuario que hizo la acción
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Nombre de la tabla afectada
            $table->string('tabla');

            // Tipo de acción: create, update, delete
            $table->string('accion');

            // Datos antes del cambio
            $table->json('antes')->nullable();

            // Datos después del cambio
            $table->json('despues')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
