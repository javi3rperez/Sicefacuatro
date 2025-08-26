<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('movements')) {
            Schema::create('movements', function (Blueprint $table) {
                $table->id();
                $table->enum('type', ['entry', 'exit']); // Entrada o salida
                $table->unsignedInteger('quantity'); // Cantidad
                $table->foreignId('warehouse_id')->constrained(); // Ubicación (almacén)
                $table->foreignId('element_id')->constrained(); // Producto
                $table->timestamps();
            });
        }
        // Si la tabla ya existe, no hacer nada (para preservar datos importantes)
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // NO eliminar la tabla si tiene datos importantes
        // Solo eliminar en entorno de desarrollo o si está vacía
        if (Schema::hasTable('movements') && !\DB::table('movements')->exists()) {
            Schema::dropIfExists('movements');
        }
    }
}