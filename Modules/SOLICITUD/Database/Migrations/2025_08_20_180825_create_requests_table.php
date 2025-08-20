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
            
            // Fechas
            $table->date('request_date'); 
            $table->date('required_date');
            
            // Estado y prioridad
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            
            // Información organizacional
            $table->string('mba_area', 100);
            $table->string('regional_code', 20);
            $table->string('regional_name', 100);
            $table->string('cost_center_code', 20);
            $table->string('cost_center_name', 100);
            $table->string('office_manager_name', 100);
            
            // Cuentadante
            $table->enum('accountable_type', ['unipersonal', 'multiple']);
            $table->string('accountable_number', 50);
            
            // Destino
            $table->text('destinations_requested_goods');
            
            // Bienes
            $table->string('group_or_record_code', 50);
            $table->string('sena_code', 50);
            $table->text('item_description');
            $table->string('measurement_unit', 20);
            
            // Cantidades
            $table->decimal('requested_quantity', 10, 2);
            $table->decimal('delivered_quantity', 10, 2)->default(0);
            
            // Observaciones
            $table->text('observation')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Control de borrado y tiempos
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
