<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración:
     * 1. Crea la tabla criterios_evaluacion (criterios dinámicos por evento)
     * 2. Crea la tabla evaluacion_criterios (calificaciones por criterio)
     * 3. Modifica la tabla evaluaciones (quita campos hardcodeados)
     */
    public function up(): void
    {
        // 1. Crear tabla de criterios de evaluación por evento
        Schema::create('criterios_evaluacion', function (Blueprint $table) {
            $table->id('id_criterio');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento')->onDelete('cascade');
            $table->string('nombre', 100); // Ej: "Innovación y Creatividad"
            $table->text('descripcion')->nullable(); // Ej: "Originalidad, uso creativo de tecnologías"
            $table->integer('ponderacion'); // Porcentaje: 25 = 25%
        });

        // 2. Crear tabla pivot para calificaciones por criterio
        Schema::create('evaluacion_criterios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_evaluacion')->constrained('evaluaciones', 'id_evaluacion')->onDelete('cascade');
            $table->foreignId('id_criterio')->constrained('criterios_evaluacion', 'id_criterio')->onDelete('cascade');
            $table->decimal('calificacion', 5, 2); // 0-100 puntos
            
            // Un criterio solo se califica una vez por evaluación
            $table->unique(['id_evaluacion', 'id_criterio']);
        });

        // 3. Modificar tabla evaluaciones - quitar campos hardcodeados
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->dropColumn([
                'calificacion_innovacion',
                'calificacion_funcionalidad',
                'calificacion_presentacion',
                'calificacion_impacto',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar campos hardcodeados en evaluaciones
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->decimal('calificacion_innovacion', 5, 2)->nullable()->after('id_jurado');
            $table->decimal('calificacion_funcionalidad', 5, 2)->nullable()->after('calificacion_innovacion');
            $table->decimal('calificacion_presentacion', 5, 2)->nullable()->after('calificacion_funcionalidad');
            $table->decimal('calificacion_impacto', 5, 2)->nullable()->after('calificacion_presentacion');
        });

        // Eliminar tablas en orden inverso (por las FK)
        Schema::dropIfExists('evaluacion_criterios');
        Schema::dropIfExists('criterios_evaluacion');
    }
};
