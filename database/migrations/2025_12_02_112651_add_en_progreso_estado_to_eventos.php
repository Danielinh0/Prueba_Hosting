<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Eliminar constraint anterior del campo estado
        DB::statement("ALTER TABLE eventos DROP CONSTRAINT IF EXISTS eventos_estado_check");
        
        // Agregar nuevo constraint con el estado "En Progreso"
        DB::statement("
            ALTER TABLE eventos
            ADD CONSTRAINT eventos_estado_check 
            CHECK (estado IN ('Próximo', 'Activo', 'En Progreso', 'Cerrado', 'Finalizado'))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar constraint actual
        DB::statement("ALTER TABLE eventos DROP CONSTRAINT IF EXISTS eventos_estado_check");
        
        // Volver al constraint anterior (sin "En Progreso")
        DB::statement("
            ALTER TABLE eventos
            ADD CONSTRAINT eventos_estado_check 
            CHECK (estado IN ('Próximo', 'Activo', 'Cerrado', 'Finalizado'))
        ");
    }
};
