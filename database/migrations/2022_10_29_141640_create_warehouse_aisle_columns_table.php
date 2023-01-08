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
        Schema::create('warehouse_aisle_columns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('warehouse_aisle_id');
            $table->string('code', 30)->unique();
            $table->timestamps();

            $table->foreign('warehouse_aisle_id')->references('id')->on('warehouse_aisles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_aisle_columns');
    }
};
