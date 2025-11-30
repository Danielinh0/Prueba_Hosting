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
        Schema::create('recurso_equipos', function (Blueprint $table) {
            $table->id('id_recurso');
            $table->foreignId('id_equipo')->constrained('equipos', 'id_equipo')->onDelete('cascade');
            $table->foreignId('subido_por')->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->string('nombre');
            $table->string('tipo', 50);
            $table->string('url');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurso_equipos');
    }
};
