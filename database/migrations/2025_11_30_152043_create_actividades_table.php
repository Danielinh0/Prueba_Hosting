<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id('id_actividad');
            $table->string('tipo', 50);
            $table->foreignId('id_usuario')->nullable()->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_equipo')->nullable()->constrained('equipos', 'id_equipo')->onDelete('cascade');
            $table->foreignId('id_evento')->nullable()->constrained('eventos', 'id_evento')->onDelete('cascade');
            $table->text('descripcion')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index('id_evento');
            $table->index('id_equipo');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
