<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidence', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            
            // Ruta de la imagen de evidencia (puede ser nulo temporalmente)
            $table->string('evidence_path')->nullable();
            
            // Relación con la tabla de movimientos
            $table->unsignedBigInteger('movement_id');
            $table->foreign('movement_id')
                  ->references('id')
                  ->on('movements')
                  ->onDelete('cascade'); // Eliminación en cascada
                  
            // Timestamps automáticos
            $table->timestamps();
            
            // Índices para mejor performance
            $table->index('movement_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidence');
    }
};