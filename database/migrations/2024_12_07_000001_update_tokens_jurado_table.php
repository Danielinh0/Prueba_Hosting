<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tokens_jurado', function (Blueprint $table) {
            // Agregar timestamp created_at
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // Agregar columnas adicionales para información completa del jurado
            $table->string('nombre_destinatario', 100)->nullable();
            $table->string('apellido_paterno', 100)->nullable();
            $table->string('apellido_materno', 100)->nullable();
            $table->string('especialidad_sugerida', 200)->nullable();
            $table->string('empresa_institucion', 200)->nullable();
            $table->text('mensaje_personalizado')->nullable();
            $table->text('eventos_asignar')->nullable();
            $table->integer('creado_por')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tokens_jurado', function (Blueprint $table) {
            $table->dropColumn([
                'created_at',
                'nombre_destinatario',
                'apellido_paterno',
                'apellido_materno',
                'especialidad_sugerida',
                'empresa_institucion',
                'mensaje_personalizado',
                'eventos_asignar',
                'creado_por'
            ]);
        });
    }
};