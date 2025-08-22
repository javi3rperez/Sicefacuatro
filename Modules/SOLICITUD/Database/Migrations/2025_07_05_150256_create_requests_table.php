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
            $table->enum('status', ['Aceptado', 'Rechazado', 'En espera'])->default('pending');
            
        
            // Campos de información organizacional
            $table->string('mba_area', 100); // Área/MBA
            $table->string('regional_code', 20); // Código regional
            $table->string('regional_name', 100); // Nombre regional
            $table->string('cost_center_code', 20); // Código centro de costo
            $table->string('cost_center_name', 100); // Nombre centro de costo
            $table->string('office_manager_name', 100); // Nombre jefe de oficina
            
            // Campos de cuentadante
            $table->enum('accountable_type', ['unipersonal', 'multiple']); // Tipo cuentadante
            $table->string('accountable_number', 50); // N° de cuentadante
            
            // Campos de destino
            $table->text('destinations_requested_goods'); // Destinos de los bienes solicitados         
            // Campos de identificación de bienes
            $table->string('group_or_record_code', 50); // Código de grupo o ficha
            $table->string('sena_code', 50); // Código SENA
            $table->text('item_description'); // Descripción del bien
            $table->string('measurement_unit', 20); // Unidad de medida
            
            // Campos de cantidades
            $table->decimal('requested_quantity', 10, 2); // Cantidad solicitada
            $table->decimal('delivered_quantity', 10, 2)->default(0); // Cantidad entregada
            
            // Observación (opcional)
            $table->text('observation')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};