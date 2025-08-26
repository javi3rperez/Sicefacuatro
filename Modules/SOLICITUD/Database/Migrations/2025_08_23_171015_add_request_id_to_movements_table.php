<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Verificar si la tabla movements existe y si no tiene la columna request_id
        if (Schema::hasTable('movements') && !Schema::hasColumn('movements', 'request_id')) {
            Schema::table('movements', function (Blueprint $table) {
                $table->foreignId('request_id')
                      ->nullable()
                      ->constrained('requests')
                      ->onDelete('cascade');
            });
            
            // Opcional: Actualizar registros existentes si es necesario
            // \DB::table('movements')->whereNull('request_id')->update(['request_id' => 1]);
        }
    }

    public function down()
    {
        if (Schema::hasTable('movements') && Schema::hasColumn('movements', 'request_id')) {
            Schema::table('movements', function (Blueprint $table) {
                $table->dropForeign(['request_id']);
                $table->dropColumn('request_id');
            });
        }
    }
};