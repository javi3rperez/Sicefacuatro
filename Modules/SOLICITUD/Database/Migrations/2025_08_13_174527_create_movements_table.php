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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['entry', 'exit']); // Entrada o salida
            $table->unsignedInteger('quantity'); // Cantidad
            $table->foreignId('warehouse_id')->constrained(); // Ubicación (almacén)
            $table->foreignId('element_id')->constrained(); // Producto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
}
