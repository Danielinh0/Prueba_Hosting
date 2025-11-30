<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PROYECTOS 
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id('id_proyecto');
            // Relación 1:1 con Inscripción (debe existir la tabla inscripciones_evento antes)
            $table->foreignId('id_inscripcion')->unique()->constrained('inscripciones_evento', 'id_inscripcion')->onDelete('cascade');
            $table->string('nombre', 200);
            $table->text('descripcion_tecnica')->nullable();
            $table->string('repositorio_url', 255)->nullable();
            $table->timestamps();
        });

        // AVANCES
        Schema::create('avances', function (Blueprint $table) {
            $table->id('id_avance');
            $table->foreignId('id_proyecto')->constrained('proyectos', 'id_proyecto')->onDelete('cascade');
            $table->foreignId('id_usuario_registro')->constrained('users', 'id_usuario');
            $table->string('titulo', 100)->nullable();
            $table->text('descripcion');
            $table->string('archivo_evidencia', 255)->nullable();
            $table->timestamps();
        });

        // EVALUACIONES
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id('id_evaluacion');
            $table->foreignId('id_avance')->constrained('avances', 'id_avance')->onDelete('cascade');
            $table->foreignId('id_jurado')->constrained('jurados', 'id_usuario');
            
            $table->decimal('calificacion', 5, 2);
            $table->text('retroalimentacion')->nullable();
            $table->timestamp('fecha_evaluacion')->useCurrent();

            $table->unique(['id_avance', 'id_jurado']);
        });

        //CONSTANCIAS
        Schema::create('constancias', function (Blueprint $table) {
            $table->id('id_constancia');
            $table->foreignId('id_usuario')->constrained('users', 'id_usuario');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento');
            $table->string('tipo', 50); 
            $table->uuid('folio_uuid'); 
            $table->string('url_descarga', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('constancias');
        Schema::dropIfExists('evaluaciones');
        Schema::dropIfExists('avances');
        Schema::dropIfExists('proyectos');
    }
};