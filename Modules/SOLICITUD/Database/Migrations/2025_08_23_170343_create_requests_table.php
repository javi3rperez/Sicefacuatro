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

            
            $table->foreignId('productive_unit_warehouse_id')
                  ->nullable()
                  ->constrained('productive_unit_warehouses')
                  ->onDelete('cascade');

            $table->foreignId('movement_type_id')->constrained('movement_types')->onDelete('cascade');
            
            // Campos de fechas
            $table->date('request_date');
            $table->date('required_date');
            
            // Campos de estado y prioridad
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            
            // Campos de información organizacional
            $table->string('mba_area', 100);
            $table->string('regional_code', 20);
            $table->string('regional_name', 100);
            $table->string('cost_center_code', 20);
            $table->string('cost_center_name', 100);
            $table->string('office_manager_name', 100);
            
            // Campos de cuentadante
            $table->enum('accountable_type', ['unipersonal', 'multiple']);
            $table->string('accountable_name', 100);
            $table->string('accountable_number', 50);
            
            // Campos de destino
            $table->text('destinations_requested_goods');
            
            // Campos de firma
            $table->string('signature_name', 100)->nullable();
            $table->string('signature_role', 100)->nullable();
            $table->string('signature_path')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');

            // 🔹 Nuevos campos de aprobación
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('approved_by_name', 100)->nullable();
            
            // Timestamps
            $table->softDeletes(); // deleted_at
            $table->timestamps();  // created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
