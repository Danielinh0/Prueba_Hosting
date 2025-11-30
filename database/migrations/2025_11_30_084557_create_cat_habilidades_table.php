<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla catálogo de habilidades
        Schema::create('cat_habilidades', function (Blueprint $table) {
            $table->id('id_habilidad');
            $table->string('nombre', 100)->unique();
            $table->string('categoria', 50)->nullable();
            $table->string('icono', 50)->nullable();
            $table->string('color', 20)->nullable();
            $table->timestamps();
        });

        // Tabla pivot estudiante_habilidades
        Schema::create('estudiante_habilidades', function (Blueprint $table) {
            $table->foreignId('id_usuario')->constrained('estudiantes', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_habilidad')->constrained('cat_habilidades', 'id_habilidad')->onDelete('cascade');
            $table->string('nivel', 20)->default('Básico'); // Básico, Intermedio, Avanzado
            $table->timestamps();
            
            $table->primary(['id_usuario', 'id_habilidad']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiante_habilidades');
        Schema::dropIfExists('cat_habilidades');
    }
};
