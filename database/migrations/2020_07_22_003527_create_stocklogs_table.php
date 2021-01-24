<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocklogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocklogs', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->string('net_wt')->nullable();
            $table->string('unit')->nullable();
            $table->string('brand')->nullable();
            $table->string('oldstock');
            $table->string('newstock');
            $table->string('status');
            $table->string('quantity');
            $table->string('description')->nullable();
            $table->string('stock_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocklogs');
    }
}
