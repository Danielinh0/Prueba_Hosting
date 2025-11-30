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
        Schema::create('logros', function (Blueprint $table) {
            $table->id('id_logro');
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('icono', 50)->nullable();
            $table->string('tipo', 50)->index();
            $table->string('condicion');
            $table->integer('puntos_xp');
            $table->timestamps();
        });

        Schema::create('usuario_logros', function (Blueprint $table) {
            $table->id('id_usuario_logro');
            $table->foreignId('id_usuario')->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_logro')->constrained('logros', 'id_logro')->onDelete('cascade');
            $table->foreignId('id_evento')->nullable()->constrained('eventos', 'id_evento')->onDelete('set null');
            $table->timestamp('fecha_obtencion')->useCurrent();
            $table->timestamps();

            $table->unique(['id_usuario', 'id_logro', 'id_evento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_logros');
        Schema::dropIfExists('logros');
    }
};
