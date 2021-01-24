<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('invoice_number')->nullable();
            $table->string('cashier')->nullable();
            $table->string('item_qty');
            $table->string('total');
            $table->string('cash');
            $table->string('change');
            $table->string('VAT_sales')->nullable();
            $table->string('VAT_exempt')->nullable();
            $table->string('VAT_zerorate')->nullable();
            $table->string('VAT')->nullable();
            $table->string('status')->nullable();
            $table->string('discount');
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
        Schema::dropIfExists('invoices');
    }
}
