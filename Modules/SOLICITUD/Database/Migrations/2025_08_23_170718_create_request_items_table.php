<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade');

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

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_items');
    }
}