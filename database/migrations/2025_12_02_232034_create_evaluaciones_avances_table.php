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
        Schema::create('evaluaciones_avances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_avance')->constrained('avances', 'id_avance')->onDelete('cascade');
            $table->foreignId('id_jurado')->constrained('jurados', 'id_usuario')->onDelete('cascade');
            $table->integer('calificacion');
            $table->text('comentarios')->nullable();
            $table->dateTime('fecha_evaluacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_avances');
    }
};
