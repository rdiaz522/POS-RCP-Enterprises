<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('net_wt')->nullable();
            $table->string('unit')->nullable();
            $table->string('price');
            $table->string('profit')->nullable();;
            $table->string('quantity');
            $table->string('subtotal');
            $table->string('cashier');
            $table->string('status')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('voids');
    }
}
