<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroundHandleRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ground_handle_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->decimal('currency_rate')->nullable();
            $table->date('validity_from')->nullable();
            $table->date('validity_to')->nullable();
            $table->decimal('purchase_price',20,2)->nullable();
            $table->decimal('sale_tax',20,2)->nullable();
            $table->decimal('vat',20,2)->nullable();
            $table->decimal('with_holding',20,2)->nullable();
            $table->decimal('net_sale',20,2)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('ground_handle_rates');
    }
}
