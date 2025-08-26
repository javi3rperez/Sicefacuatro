<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Verificar si la tabla ya existe antes de crearla
        if (!Schema::hasTable('evidences')) {
            Schema::create('evidences', function (Blueprint $table) {
                $table->id(); // ID autoincremental
                
                // Clave foránea para categoría (asumiendo que existe una tabla categories)
                $table->foreignId('category_id')
                      ->constrained('categories')
                      ->onDelete('cascade')
                      ->comment('ID de la categoría asociada');
                $table->foreignId('element_id');//elementos

                $table->unsignedInteger('quantity'); // Cantidad

                $table->string('product_name', 100)
                      ->comment('Nombre del producto');
                $table->enum('movement_type', ['entry', 'exit'])
                      ->comment('Tipo de movimiento: entrada (entry) o salida (exit)');
                
                $table->string('evidence_path', 255)
                      ->nullable()
                      ->comment('Ruta del archivo de evidencia en el sistema de archivos');
                
                $table->text('comments')
                      ->nullable()
                      ->comment('Comentarios adicionales sobre la evidencia');
                
                // Timestamps automáticos
                $table->timestamps();
                
                // Índices para mejorar el rendimiento
                $table->index('category_id');
                $table->index('movement_type');
            });
            
            echo "Tabla evidences creada exitosamente\n";
        } else {
            echo "La tabla evidences ya existe. No se realizaron cambios para preservar datos.\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Solo eliminar la tabla si está vacía para no perder datos importantes
        if (Schema::hasTable('evidences')) {
            // Verificar si la tabla tiene datos
            $hasData = \DB::table('evidences')->exists();
            
            if (!$hasData) {
                Schema::dropIfExists('evidences');
                echo "Tabla evidences eliminada (estaba vacía)\n";
            } else {
                echo "La tabla evidences tiene datos importantes. No se eliminó para prevenir pérdida de información.\n";
            }
        }
    }
};