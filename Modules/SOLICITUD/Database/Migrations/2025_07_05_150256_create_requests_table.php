<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            
            // Claves foráneas
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
            $table->foreignId('productive_unit_warehouse_id')->constrained('productive_unit_warehouses')->onDelete('cascade');
            $table->foreignId('movement_type_id')->constrained('movement_types')->onDelete('cascade');
            
            // Campos de fechas
            $table->date('request_date');
            $table->date('required_date');
            
            // Campos de estado y prioridad
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            
            // Observación (opcional)
            $table->text('observation')->nullable();
            
            // SoftDeletes y timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};