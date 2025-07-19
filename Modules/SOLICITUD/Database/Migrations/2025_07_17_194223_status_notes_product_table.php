<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StatusNotesProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('date');
            $table->text('notes')->nullable()->after('status');
});
    }

   
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['status', 'notes']);
});
    }
}
