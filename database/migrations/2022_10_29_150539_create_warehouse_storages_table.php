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
        Schema::create('warehouse_storages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('warehouse_aisle_id');
            $table->foreignUuid('warehouse_aisle_column_id');
            $table->foreignUuid('warehouse_aisle_row_id');
            $table->timestamps();

            $table->foreign('warehouse_aisle_id')->references('id')->on('warehouse_aisles')->onDelete('cascade');
            $table->foreign('warehouse_aisle_column_id')->references('id')->on('warehouse_aisle_columns')->onDelete('cascade');
            $table->foreign('warehouse_aisle_row_id')->references('id')->on('warehouse_aisle_rows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_storages');
    }
};
