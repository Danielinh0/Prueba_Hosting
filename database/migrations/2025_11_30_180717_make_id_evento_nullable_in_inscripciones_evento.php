<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inscripciones_evento', function (Blueprint $table) {
            // Hacer id_evento nullable para permitir equipos sin evento
            $table->dropForeign(['id_evento']);
            $table->bigInteger('id_evento')->nullable()->change();
            $table->foreign('id_evento')->references('id_evento')->on('eventos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('inscripciones_evento', function (Blueprint $table) {
            $table->dropForeign(['id_evento']);
            $table->bigInteger('id_evento')->nullable(false)->change();
            $table->foreign('id_evento')->references('id_evento')->on('eventos')->onDelete('cascade');
        });
    }
};
