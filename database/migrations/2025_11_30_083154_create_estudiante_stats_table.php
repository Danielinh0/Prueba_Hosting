<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudiante_stats', function (Blueprint $table) {
            $table->foreignId('id_usuario')->primary()->constrained('estudiantes', 'id_usuario')->onDelete('cascade');
            $table->integer('total_xp')->default(0);
            $table->integer('nivel')->default(1);
            $table->integer('eventos_participados')->default(0);
            $table->integer('proyectos_completados')->default(0);
            $table->integer('veces_lider')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiante_stats');
    }
};
