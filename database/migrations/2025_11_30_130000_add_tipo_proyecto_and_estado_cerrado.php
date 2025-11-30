<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Crear tabla proyectos_evento
        Schema::create('proyectos_evento', function (Blueprint $table) {
            $table->id('id_proyecto_evento');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento')->onDelete('cascade');
            $table->foreignId('id_inscripcion')->nullable()->constrained('inscripciones_evento', 'id_inscripcion')->onDelete('cascade');
            
            // Información del proyecto
            $table->string('titulo', 200);
            $table->text('descripcion_completa')->nullable();
            $table->text('objetivo')->nullable();
            $table->text('requisitos')->nullable();
            $table->text('premios')->nullable();
            
            // Archivos
            $table->string('archivo_bases', 255)->nullable();
            $table->string('archivo_recursos', 255)->nullable();
            $table->string('url_externa', 255)->nullable();
            
            // Control de publicación
            $table->boolean('publicado')->default(false);
            $table->timestamp('fecha_publicacion')->nullable();
            
            $table->timestamps();
            
            // Si id_inscripcion es NULL, es para todos
            // Si tiene valor, es solo para ese equipo
            $table->unique(['id_evento', 'id_inscripcion']);
        });

        // 2. Actualizar tabla evaluaciones - Cambiar de evaluar avances a evaluar inscripciones
        Schema::dropIfExists('evaluaciones');
        
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id('id_evaluacion');
            $table->foreignId('id_inscripcion')->constrained('inscripciones_evento', 'id_inscripcion')->onDelete('cascade');
            $table->foreignId('id_jurado')->constrained('jurados', 'id_usuario')->onDelete('cascade');
            
            // Criterios de evaluación (0-100)
            $table->decimal('calificacion_innovacion', 5, 2)->nullable();
            $table->decimal('calificacion_funcionalidad', 5, 2)->nullable();
            $table->decimal('calificacion_presentacion', 5, 2)->nullable();
            $table->decimal('calificacion_impacto', 5, 2)->nullable();
            
            // Calificación final promedio
            $table->decimal('calificacion_final', 5, 2)->nullable();
            
            // Comentarios
            $table->text('comentarios_fortalezas')->nullable();
            $table->text('comentarios_areas_mejora')->nullable();
            $table->text('comentarios_generales')->nullable();
            
            $table->enum('estado', ['Borrador', 'Finalizada'])->default('Borrador');
            
            $table->timestamps();
            
            // Un jurado evalúa una vez por equipo
            $table->unique(['id_inscripcion', 'id_jurado']);
        });

        // 3. Agregar campo tipo_proyecto a eventos
        Schema::table('eventos', function (Blueprint $table) {
            $table->string('tipo_proyecto', 20)->nullable()->after('estado');
            // null = no configurado
            // 'general' = un proyecto para todos
            // 'individual' = proyectos por equipo
        });

        // 4. Modificar el estado de eventos para soportar "Cerrado"
        DB::statement("ALTER TABLE eventos DROP CONSTRAINT IF EXISTS eventos_estado_check");
        DB::statement("ALTER TABLE eventos ADD CONSTRAINT eventos_estado_check CHECK (estado IN ('Próximo', 'Activo', 'Cerrado', 'Finalizado'))");
    }

    public function down(): void
    {
        // Revertir constraint del estado
        DB::statement("ALTER TABLE eventos DROP CONSTRAINT IF EXISTS eventos_estado_check");
        DB::statement("ALTER TABLE eventos ADD CONSTRAINT eventos_estado_check CHECK (estado IN ('Próximo', 'Activo', 'Finalizado'))");
        
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('tipo_proyecto');
        });
        
        // Revertir evaluaciones a su estado original
        Schema::dropIfExists('evaluaciones');
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id('id_evaluacion');
            $table->foreignId('id_avance')->constrained('avances', 'id_avance')->onDelete('cascade');
            $table->foreignId('id_jurado')->constrained('jurados', 'id_usuario');
            $table->decimal('calificacion', 5, 2);
            $table->text('retroalimentacion')->nullable();
            $table->timestamp('fecha_evaluacion')->useCurrent();
            $table->unique(['id_avance', 'id_jurado']);
        });
        
        Schema::dropIfExists('proyectos_evento');
    }
};

