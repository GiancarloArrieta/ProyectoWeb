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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('id_auxiliar_asignado')->nullable()->constrained('usuarios')->after('id_departamento_asignado');
            $table->dateTime('fecha_asignacion')->nullable()->after('id_auxiliar_asignado');
            $table->dateTime('fecha_inicio')->nullable()->after('fecha_asignacion');
            $table->dateTime('fecha_finalizacion')->nullable()->after('fecha_inicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['id_auxiliar_asignado']);
            $table->dropColumn(['id_auxiliar_asignado', 'fecha_asignacion', 'fecha_inicio', 'fecha_finalizacion']);
        });
    }
};
